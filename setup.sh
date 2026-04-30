#!/bin/bash
# Mpemba Store - Quick Setup Script
# This script automates the initial setup

echo "========================================="
echo "  Mpemba Store - Backend Setup"
echo "========================================="
echo ""

# Check if we're in the dee directory
if [ ! -f "composer.json" ]; then
    echo "Error: Please run this script from the 'dee' directory"
    exit 1
fi

echo "Step 1: Installing dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-interaction
    echo "✓ Dependencies installed"
else
    echo "✗ Composer not found. Please install Composer first."
    exit 1
fi

echo ""
echo "Step 2: Checking .env file..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "✓ .env file created from .env.example"
    echo "⚠ Please edit .env with your database credentials"
    echo "  Run: nano .env"
    read -p "Press Enter after configuring .env..."
else
    echo "✓ .env file already exists"
fi

echo ""
echo "Step 3: Setting up database..."
if php database/setup.php; then
    echo "✓ Database initialized"
else
    echo "✗ Database setup failed"
    exit 1
fi

echo ""
echo "Step 4: Seeding sample data..."
if php database/seed.php; then
    echo "✓ Sample data created"
else
    echo "✗ Data seeding failed"
    exit 1
fi

echo ""
echo "========================================="
echo "  Setup Complete!"
echo "========================================="
echo ""
echo "Next steps:"
echo "1. Start development server:"
echo "   php -S localhost:8000"
echo ""
echo "2. Test the API:"
echo "   curl http://localhost:8000/api/products"
echo ""
echo "3. Login with:"
echo "   username: admin"
echo "   password: admin123"
echo ""
echo "For more info, see QUICK_START.md or BACKEND_SETUP.md"
