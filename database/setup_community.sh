#!/bin/bash
# Community Platform Database Setup Script
# Run this to set up all community tables and seed data

echo "🚀 Setting up Nebatech AI Academy Community Platform..."

# Database credentials
DB_HOST="localhost"
DB_NAME="nebatech_academy"
DB_USER="root"
DB_PASS=""

echo "📊 Creating community tables..."
mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME < schema.sql

if [ $? -eq 0 ]; then
    echo "✅ Community tables created successfully!"
else
    echo "❌ Error creating tables. Please check your database connection."
    exit 1
fi

echo "🌱 Seeding initial data..."
mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME < seed_community.sql

if [ $? -eq 0 ]; then
    echo "✅ Seed data inserted successfully!"
else
    echo "❌ Error seeding data."
    exit 1
fi

echo ""
echo "🎉 Community Platform setup complete!"
echo ""
echo "📋 What was created:"
echo "  • 15 new database tables"
echo "  • 6 discussion categories"
echo "  • 20 achievement badges"
echo "  • XP system configured"
echo ""
echo "🔗 Access your community at: http://localhost/Nebatech-AI-Academy/public/community"
echo ""
echo "👤 Next steps:"
echo "  1. Create your first discussion post"
echo "  2. Customize categories and badges"
echo "  3. Invite your first members"
echo ""
