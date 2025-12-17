# Paystack Integration Troubleshooting

## ✅ Fixes Applied

1. **Added error handling** - Checks if PaystackPop is loaded
2. **Added useToast import** - Imported at top of script
3. **Added window.PaystackPop** - Explicitly reference from window object
4. **Added try-catch** - Catches any initialization errors

## 🧪 Testing Steps

### 1. Restart Dev Server

**IMPORTANT:** You must restart the Vue dev server for changes to take effect!

```bash
# Stop the current server (Ctrl+C)
# Then restart:
cd Client/E-commerce-Rufars-food-vue
npm run dev
```

### 2. Clear Browser Cache

- Open DevTools (F12)
- Right-click refresh button
- Select "Empty Cache and Hard Reload"

OR

- Use Incognito/Private window

### 3. Test Payment Flow

1. Go to http://localhost:5173
2. Add items to cart
3. Go to checkout
4. Fill shipping info
5. Select "Paystack"
6. Open browser console (F12)
7. Click "Pay" button

### 4. Check Console

**If you see:**
```
PaystackPop is not defined. Make sure the Paystack script is loaded
```

**Solution:**
- Refresh the page
- Check if script is loaded: View Page Source → Look for `https://js.paystack.co/v1/inline.js`

**If you see:**
```
Paystack initialization error: ...
```

**Solution:**
- Check the error details in console
- Verify email is valid
- Verify amount is a number

## 🔍 Debug Checklist

### Check 1: Paystack Script Loaded

Open browser console and type:
```javascript
typeof PaystackPop
```

**Expected:** `"object"` or `"function"`
**If "undefined":** Script not loaded, refresh page

### Check 2: Environment Variable

Open browser console and type:
```javascript
import.meta.env.VITE_PAYSTACK_PUBLIC_KEY
```

**Expected:** `"pk_test_4830c11209bb97f1390dfe6694a96b93b1839aa1"`
**If undefined:** Restart dev server

### Check 3: Form Data

Before clicking Pay, open console and type:
```javascript
// Check if email is filled
document.querySelector('input[type="email"]').value
```

**Expected:** Valid email address
**If empty:** Fill the form first

### Check 4: Payment Method Selected

```javascript
// Should be 'paystack'
```

Check that Paystack button is highlighted/selected

## 🎯 Expected Behavior

### When Everything Works:

1. Click "Pay" button
2. See toast: "Opening Paystack payment..."
3. **Paystack popup opens** (modal/iframe)
4. Enter card details
5. Payment processes
6. See toast: "Payment successful! Processing your order..."
7. Order created
8. Success page shown

### Current Flow in Code:

```javascript
handleSubmit() {
  // Validate form
  if (!valid) return
  
  // Check payment method
  if (paymentMethod === 'paystack') {
    toast.info('Opening Paystack payment...')
    initializePaystack()  // ← Should open popup
    return
  }
}

initializePaystack() {
  // Check if PaystackPop exists
  if (!window.PaystackPop) {
    toast.error('Paystack not loaded')
    return
  }
  
  // Setup Paystack
  const handler = window.PaystackPop.setup({
    key: 'pk_test_...',
    email: formData.email,
    amount: total * 100,
    callback: (response) => {
      // Success!
      createOrder(response.reference)
    }
  })
  
  // Open popup
  handler.openIframe()  // ← This should show popup
}
```

## 🐛 Common Issues

### Issue 1: Only Toast Shows, No Popup

**Cause:** PaystackPop not loaded or error in initialization

**Fix:**
1. Check browser console for errors
2. Verify script is loaded (see Check 1 above)
3. Restart dev server
4. Clear browser cache

### Issue 2: "PaystackPop is not defined"

**Cause:** Script not loaded or loaded after component

**Fix:**
1. Refresh page
2. Check index.html has script tag
3. Check network tab - script should load successfully

### Issue 3: Popup Opens But Closes Immediately

**Cause:** Invalid configuration or amount

**Fix:**
1. Check amount is positive number
2. Check email is valid
3. Check API key is correct

### Issue 4: Payment Succeeds But Order Not Created

**Cause:** Error in createOrder method

**Fix:**
1. Check Laravel logs: `Sever/storage/logs/laravel.log`
2. Check browser console for errors
3. Verify API endpoint is working

## 📊 Network Tab Check

Open DevTools → Network tab:

**Should see:**
1. `inline.js` - Paystack script (Status: 200)
2. When popup opens: Requests to `paystack.co`
3. After payment: POST to `/api/orders`

## ✅ Verification Steps

After restarting dev server:

- [ ] Go to checkout page
- [ ] Open browser console (F12)
- [ ] Type: `typeof PaystackPop`
- [ ] Should see: `"object"` or `"function"`
- [ ] Fill shipping form
- [ ] Select Paystack
- [ ] Click Pay
- [ ] Popup should open!

## 🆘 If Still Not Working

1. **Share console errors:**
   - Open DevTools (F12)
   - Go to Console tab
   - Click Pay button
   - Copy any red error messages

2. **Check Network tab:**
   - Go to Network tab
   - Click Pay button
   - Look for failed requests (red)
   - Share the error details

3. **Verify files:**
   - `index.html` has Paystack script
   - `.env` has API key
   - Dev server restarted

## 🎉 Success Indicators

**You'll know it's working when:**
1. ✅ Click Pay → Toast shows "Opening Paystack payment..."
2. ✅ Paystack popup/modal appears on screen
3. ✅ Can see payment form inside popup
4. ✅ Can enter card details
5. ✅ Payment processes
6. ✅ Order is created

The popup should look like a modal/iframe overlay on your page with Paystack's payment form inside.

---

**Remember:** Always restart the dev server after making changes to see the updates!
