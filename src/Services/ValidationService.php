<?php

namespace Nebatech\Services;

use Nebatech\Exceptions\ValidationException;

class ValidationService
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];
    protected array $customMessages = [];

    public function __construct(array $data, array $rules, array $customMessages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }

    /**
     * Validate data against rules
     */
    public function validate(): array
    {
        foreach ($this->rules as $field => $ruleSet) {
            $rulesArray = is_array($ruleSet) ? $ruleSet : explode('|', $ruleSet);
            
            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $rule);
            }
        }

        if (!empty($this->errors)) {
            throw new ValidationException($this->errors);
        }

        return $this->data;
    }

    /**
     * Apply a single validation rule
     */
    protected function applyRule(string $field, string $rule): void
    {
        $value = $this->data[$field] ?? null;

        // Required rule
        if ($rule === 'required' && $this->isEmpty($value)) {
            $this->addError($field, 'required', ucfirst($field) . ' is required');
            return;
        }

        // Skip other validations if field is empty and not required
        if ($this->isEmpty($value)) {
            return;
        }

        // Min length
        if (str_starts_with($rule, 'min:')) {
            $min = (int) substr($rule, 4);
            if (strlen($value) < $min) {
                $this->addError($field, 'min', ucfirst($field) . " must be at least {$min} characters");
            }
        }

        // Max length
        if (str_starts_with($rule, 'max:')) {
            $max = (int) substr($rule, 4);
            if (strlen($value) > $max) {
                $this->addError($field, 'max', ucfirst($field) . " must not exceed {$max} characters");
            }
        }

        // Email
        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email', ucfirst($field) . ' must be a valid email address');
        }

        // URL
        if ($rule === 'url' && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, 'url', ucfirst($field) . ' must be a valid URL');
        }

        // Numeric
        if ($rule === 'numeric' && !is_numeric($value)) {
            $this->addError($field, 'numeric', ucfirst($field) . ' must be a number');
        }

        // Integer
        if ($rule === 'integer' && !filter_var($value, FILTER_VALIDATE_INT)) {
            $this->addError($field, 'integer', ucfirst($field) . ' must be an integer');
        }

        // Alpha
        if ($rule === 'alpha' && !ctype_alpha(str_replace(' ', '', $value))) {
            $this->addError($field, 'alpha', ucfirst($field) . ' must contain only letters');
        }

        // Alphanumeric
        if ($rule === 'alphanumeric' && !ctype_alnum(str_replace(' ', '', $value))) {
            $this->addError($field, 'alphanumeric', ucfirst($field) . ' must contain only letters and numbers');
        }

        // In (enum)
        if (str_starts_with($rule, 'in:')) {
            $options = explode(',', substr($rule, 3));
            if (!in_array($value, $options)) {
                $this->addError($field, 'in', ucfirst($field) . ' must be one of: ' . implode(', ', $options));
            }
        }

        // Confirmed (password confirmation)
        if ($rule === 'confirmed') {
            $confirmField = $field . '_confirmation';
            if (!isset($this->data[$confirmField]) || $value !== $this->data[$confirmField]) {
                $this->addError($field, 'confirmed', ucfirst($field) . ' confirmation does not match');
            }
        }

        // Same as another field
        if (str_starts_with($rule, 'same:')) {
            $otherField = substr($rule, 5);
            if (!isset($this->data[$otherField]) || $value !== $this->data[$otherField]) {
                $this->addError($field, 'same', ucfirst($field) . ' must match ' . ucfirst($otherField));
            }
        }

        // Different from another field
        if (str_starts_with($rule, 'different:')) {
            $otherField = substr($rule, 10);
            if (isset($this->data[$otherField]) && $value === $this->data[$otherField]) {
                $this->addError($field, 'different', ucfirst($field) . ' must be different from ' . ucfirst($otherField));
            }
        }
    }

    /**
     * Check if value is empty
     */
    protected function isEmpty($value): bool
    {
        return $value === null || $value === '' || (is_array($value) && empty($value));
    }

    /**
     * Add validation error
     */
    protected function addError(string $field, string $rule, string $defaultMessage): void
    {
        $key = "{$field}.{$rule}";
        $message = $this->customMessages[$key] ?? $this->customMessages[$field] ?? $defaultMessage;
        
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }

    /**
     * Get validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Static helper for quick validation
     */
    public static function make(array $data, array $rules, array $customMessages = []): array
    {
        $validator = new self($data, $rules, $customMessages);
        return $validator->validate();
    }
}
