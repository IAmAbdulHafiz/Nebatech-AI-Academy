<?php

namespace Nebatech\Models\Community;

use Nebatech\Core\Database;
use PDO;

class UserPreference
{
    /**
     * Get a specific preference for a user
     */
    public static function get($userId, $key, $default = null)
    {
        $sql = "SELECT preference_value 
                FROM user_preferences 
                WHERE user_id = :user_id AND preference_key = :key";
        
        $result = Database::fetch($sql, [
            'user_id' => $userId,
            'key' => $key
        ]);
        
        if ($result) {
            // Try to decode JSON, return raw value if not JSON
            $decoded = json_decode($result['preference_value'], true);
            return $decoded !== null ? $decoded : $result['preference_value'];
        }
        
        return $default;
    }

    /**
     * Get all preferences for a user
     */
    public static function getAll($userId)
    {
        $sql = "SELECT preference_key, preference_value 
                FROM user_preferences 
                WHERE user_id = :user_id";
        
        $results = Database::fetchAll($sql, ['user_id' => $userId]);
        
        $preferences = [];
        foreach ($results as $row) {
            $decoded = json_decode($row['preference_value'], true);
            $preferences[$row['preference_key']] = $decoded !== null ? $decoded : $row['preference_value'];
        }
        
        return $preferences;
    }

    /**
     * Set a preference for a user
     */
    public static function set($userId, $key, $value)
    {
        // Convert arrays/objects to JSON
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }
        
        $sql = "INSERT INTO user_preferences (user_id, preference_key, preference_value)
                VALUES (:user_id, :key, :value)
                ON DUPLICATE KEY UPDATE 
                    preference_value = VALUES(preference_value),
                    updated_at = CURRENT_TIMESTAMP";
        
        $stmt = Database::query($sql, [
            'user_id' => $userId,
            'key' => $key,
            'value' => $value
        ]);
        
        return $stmt->rowCount() > 0;
    }

    /**
     * Delete a preference for a user
     */
    public static function deletePreference($userId, $key)
    {
        return Database::delete('user_preferences', 
            'user_id = :user_id AND preference_key = :key', 
            ['user_id' => $userId, 'key' => $key]
        ) > 0;
    }

    /**
     * Get editor settings for a user with defaults
     */
    public static function getEditorSettings($userId)
    {
        $defaults = [
            'theme' => 'github-light',
            'fontSize' => 14,
            'lineNumbers' => true,
            'lineWrapping' => false,
            'tabSize' => 4,
            'indentWithTabs' => false,
            'autoCloseBrackets' => true,
            'language' => 'auto',
            'keyMap' => 'default'
        ];
        
        $settings = self::get($userId, 'editor_settings', $defaults);
        
        // Merge with defaults to ensure all keys exist
        return array_merge($defaults, $settings);
    }

    /**
     * Set editor settings for a user
     */
    public static function setEditorSettings($userId, $settings)
    {
        return self::set($userId, 'editor_settings', $settings);
    }

    /**
     * Initialize default preferences for a new user
     */
    public static function initializeDefaults($userId)
    {
        $defaults = [
            'editor_settings' => [
                'theme' => 'github-light',
                'fontSize' => 14,
                'lineNumbers' => true,
                'lineWrapping' => false,
                'tabSize' => 4,
                'indentWithTabs' => false,
                'autoCloseBrackets' => true,
                'language' => 'auto',
                'keyMap' => 'default'
            ]
        ];
        
        foreach ($defaults as $key => $value) {
            self::set($userId, $key, $value);
        }
        
        return true;
    }
}
