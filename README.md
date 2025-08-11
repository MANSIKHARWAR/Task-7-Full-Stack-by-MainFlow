# 🧾 PHP Bill Generator (Task 7 - Shop Management System)

This feature enables users to **generate a bill** for completed transactions, showing buyer details, purchased products, and total amount due — **without discounts or taxes**.  
It includes PDF export, print, preview, and search functionality.

---

## ✨ Features
- **Buyer Details**: Name, address, contact number, email.
- **Product Table**: Product name, quantity, unit price, total per item.
- **Transaction Info**: Transaction ID, purchase date, payment method.
- **Total Calculation**: Subtotal + final total amount due.
- **PDF Export**: Download bills in clean, professional layout using [Dompdf](https://github.com/dompdf/dompdf).
- **Print Support**: Print bills directly from browser.
- **Search Functionality**: Find transactions quickly and regenerate bills.
- **Stored Records**: Bills can be saved for future reference.

---

## 📂 Project Structure
Shop_manage/
│── db.php # Database connection
│── index.php # Form to add transactions
│── save_transaction.php # Saves transaction and product details
│── pdf_bill.php # Generates PDF bill
│── vendor/ # Composer dependencies (Dompdf)
│── composer.json
└── README.md

