# InfinityFree Deployment Guide

Follow these steps to deploy your **Registration Form** to InfinityFree.

## 1. Prepare Your Files
Ensure you have the following 4 files ready in a single folder on your computer:
- `index.html` (The registration form)
- `style.css` (The styling)
- `script.js` (The client-side validation)
- `submit.php` (The backend processing)

## 2. Create an InfinityFree Account
1. Go to [InfinityFree.com](https://www.infinityfree.com/).
2. Click **Register** and create an account with your email and password.
3. Verify your email address.

## 3. Create a Hosting Account (Domain)
1. In the InfinityFree Client Area, click **"Create Account"**.
2. Choose a **Subdomain** (e.g., yourname-form.rf.gd) or use a custom domain if you have one.
3. Check availability and click **"Create Account"**.
4. Wait a few minutes for the account to be set up.

## 4. Upload Files
You can use the **Online File Manager** (easiest) or an FTP client (FileZilla).

### Method A: Online File Manager
1. In your Account Dashboard, click the green **"File Manager"** button.
2. You will see a list of folders. Open the **`htdocs`** folder.
   > **Important:** `htdocs` is the public folder. Files outside it will not be accessible.
3. Delete the default files (like `index2.html`) if they exist.
4. Click the **Upload** icon (usually an arrow pointing up) -> **Upload File**.
5. Select and upload your 4 files: `index.html`, `style.css`, `script.js`, `submit.php`.
6. Confirm that `index.html` is directly inside `htdocs`.
   - Correct path: `/htdocs/index.html`
   - Incorrect path: `/htdocs/myfolder/index.html` (unless you want users to type the folder name)

## 5. Test Your Website
1. Go to your domain URL (e.g., `http://your-subdomain.rf.gd`).
   > *Note: It may take up to 72 hours for a new domain to work everywhere (DNS propagation), but usually it works within 30 minutes.*
2. You should see the Registration Form.
3. Fill out the form correctly and click **Register Now**.
4. You should be taken to the **Registration Successful** confirmation page.
5. Try filling it out incorrectly (e.g., invalid email) to see the error messages.

## 6. Troubleshooting
| Issue | Solution |
| :--- | :--- |
| **404 Not Found** | Ensure your main file is named exactly `index.html` (all lowercase) and is inside the `htdocs` folder. |
| **PHP Code Visible** | This happens if you open the file locally (file://) or if the server isn't processing PHP. **Solution:** You MUST upload files to InfinityFree (or use a local server like XAMPP) to run PHP. |
| **"Method Not Allowed"** | Ensure you are accessing `index.html` first and submitting the form. You cannot visit `submit.php` directly without data. |
| **Permission Errors** | File permissions should be `644` for files and `755` for directories (default). |

## 7. Security & Best Practices (For Production)
This project is a starter template. For a real-world production app, consider:

- **HTTPS**: InfinityFree provides free SSL. Enable it in the "Free SSL Certificates" section to get the secure lock icon.
- **Database**: Currently, data is just displayed. To save it, create a MySQL database in the Control Panel and use PHP's `mysqli` or `PDO` to insert records in `submit.php`.
- **CAPTCHA**: Add Google reCAPTCHA or similar to prevent bot spam.
- **Input Sanitization**: We used `filter_input()` and `htmlspecialchars()`, which is good practice. Always sanitize data before displaying or saving it.
- **CSRF Protection**: Add a CSRF token to the form session to prevent Cross-Site Request Forgery attacks.

---
**Good luck with your deployment!**
