# Profile Address Sync Implementation

## Overview
The user profile address fields now automatically sync with the addresses table when updated.

## Changes Made

### 1. Database Migration
**File:** `Sever/database/migrations/2025_12_12_191842_add_profile_fields_to_users_table.php`

Added the following columns to the `users` table:
- `phone` (nullable)
- `address` (nullable, text)
- `city` (nullable)
- `state` (nullable)
- `pincode` (nullable, max 10 chars)

### 2. User Model Update
**File:** `Sever/app/Models/User.php`

Added new fields to the `$fillable` array:
```php
'phone', 'address', 'city', 'state', 'pincode'
```

### 3. AuthController Enhancement
**File:** `Sever/app/Http/Controllers/AuthController.php`

Updated `updateProfile()` method to:
- Accept and validate the new profile fields
- Automatically sync address data to the `addresses` table
- Create or update a "Profile Address" entry when address fields are provided
- Set as default address if it's the user's first address

**Logic:**
- When user updates profile with address fields, it creates/updates an address record labeled "Profile Address"
- If user has no addresses, this becomes the default address
- If "Profile Address" already exists, it updates that record
- If it doesn't exist, it creates a new one

### 4. Frontend Integration
**File:** `Client/E-commerce-Rufars-food-vue/src/pages/Profile.vue`

Updated `saveProfile()` method to:
- Reload addresses after profile update
- Show the synced address in the Addresses tab immediately

## How It Works

1. User edits their profile and fills in address fields (address, city, state, pincode)
2. On save, the backend:
   - Updates the user's profile fields in the `users` table
   - Checks if address data was provided
   - Creates or updates a "Profile Address" entry in the `addresses` table
3. Frontend reloads the addresses list
4. User can now see their profile address in the Addresses tab

## Benefits

- **Single Source of Truth:** Profile address is automatically available in addresses
- **Seamless UX:** Users don't need to manually add their address twice
- **Backward Compatible:** Existing addresses are not affected
- **Smart Defaults:** First address becomes default automatically

## Testing

1. Login to the application
2. Go to Profile page
3. Click "Edit Profile"
4. Fill in: Phone, Address, City, State, Pincode
5. Click "Save Changes"
6. Switch to "Addresses" tab
7. You should see "Profile Address" with the data you entered

## API Endpoints

- `PUT /api/user/profile` - Updates user profile and syncs address
- `GET /api/addresses` - Lists all user addresses (including synced profile address)
