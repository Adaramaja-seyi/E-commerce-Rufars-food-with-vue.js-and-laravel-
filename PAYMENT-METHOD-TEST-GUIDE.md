# Payment Method Auto-Save Test Guide

## Feature Overview
When users complete checkout with a payment method (Card, COD, or UPI), it's automatically saved to their Payment Methods tab in the profile.

## How to Test

### Test 1: First Order with Card
1. **Login** to your account
2. **Add items** to cart
3. **Go to Cart** and click "Proceed to Checkout"
4. **Fill in** shipping information (or verify pre-filled data)
5. **Select "Card"** as payment method
6. **Click "Pay Now"**
7. **Wait** for order confirmation
8. **Go to Profile** → Click "Payment Methods" tab
9. **Expected Result:** You should see "Card" listed as a payment method ✅

### Test 2: Order with COD
1. **Add more items** to cart
2. **Proceed to Checkout**
3. **Select "COD"** (Cash on Delivery) as payment method
4. **Complete checkout**
5. **Go to Profile** → "Payment Methods" tab
6. **Expected Result:** You should now see both "Card" and "COD" listed ✅

### Test 3: Order with UPI
1. **Add items** to cart
2. **Checkout** and select "UPI"
3. **Complete order**
4. **Check Payment Methods** tab
5. **Expected Result:** All three methods (Card, COD, UPI) should be listed ✅

### Test 4: Duplicate Prevention
1. **Place another order** with "Card" (same as Test 1)
2. **Complete checkout**
3. **Check Payment Methods** tab
4. **Expected Result:** Still only ONE "Card" entry (no duplicates) ✅

### Test 5: Default Payment Method
1. **Check Payment Methods** tab
2. **Expected Result:** The FIRST payment method you used should be marked as "Default" ✅

## What to Look For

### In Payment Methods Tab:
- ✅ Payment method type (Card, COD, UPI)
- ✅ Last 4 digits showing as "****" (placeholder)
- ✅ "Default" badge on first method
- ✅ Edit, Set as Default, and Delete buttons

### In Payment History Tab:
- ✅ Each order shows the payment method used
- ✅ Payment status (paid/pending/failed)
- ✅ Transaction details

## Troubleshooting

### If Payment Method Doesn't Appear:

1. **Check Browser Console** for errors
2. **Verify Order Was Created:**
   - Go to Profile → Orders tab
   - Check if order appears
   - If order exists but payment method doesn't, there may be a backend issue

3. **Refresh the Page:**
   - Sometimes the payment methods list needs a refresh
   - Click on another tab, then back to Payment Methods

4. **Check Backend Logs:**
   - Look for errors in Laravel logs
   - Check if `savePaymentMethod` is being called

5. **Verify Database:**
   - Check `payment_methods` table
   - Verify records are being created

## Expected Database Records

After completing checkout with "Card", you should see in `payment_methods` table:
```
id: 1
user_id: [your user id]
type: Card
last4: ****
expiry: null
is_default: 1
created_at: [timestamp]
updated_at: [timestamp]
```

## API Endpoints Involved

1. **Create Order:** `POST /api/orders`
   - Creates order
   - Saves payment method automatically

2. **Get Payment Methods:** `GET /api/payment-methods`
   - Retrieves all saved payment methods
   - Called when loading Profile page

## Code Flow

```
User Completes Checkout
    ↓
POST /api/orders
    ↓
OrderController::createOrder()
    ↓
savePaymentMethod() called
    ↓
Checks if payment method exists
    ↓
If not exists → Create new payment method
    ↓
If exists → Skip (no duplicate)
    ↓
Order created successfully
    ↓
User goes to Profile
    ↓
loadPaymentMethods() called
    ↓
GET /api/payment-methods
    ↓
Payment methods displayed in tab
```

## Success Criteria

✅ Payment method appears in Payment Methods tab after checkout
✅ No duplicate payment methods are created
✅ First payment method is marked as default
✅ Payment method can be edited or deleted
✅ Payment method shows in Payment History tab with orders

## Common Issues

### Issue 1: Payment Method Not Showing
**Solution:** Refresh the page or navigate away and back to Profile

### Issue 2: Multiple Duplicates
**Solution:** Check if `savePaymentMethod` has duplicate prevention logic

### Issue 3: Wrong Payment Method Type
**Solution:** Verify the payment method value being sent from checkout form

## Additional Notes

- Payment methods are saved with placeholder data ("****") for security
- Actual card details are NOT stored
- Users can manually add payment methods with full details
- Auto-saved methods can be edited or deleted
- System prevents duplicate payment method types per user
