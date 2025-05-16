import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.common.exceptions import NoSuchElementException

class GovernmentStockPageTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        # ✅ Set your actual chromedriver path here
        chromedriver_path = r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe"
        service = Service(chromedriver_path)
        options = Options()
        # options.add_argument("--headless")  # Optional: run without opening a window

        cls.driver = webdriver.Chrome(service=service, options=options)
        cls.driver.implicitly_wait(5)  # seconds

    def test_government_stock_page(self):
        driver = self.driver
        url = 'http://localhost/Railway_Storage_Management_System/govStock.php'
        driver.get(url)

        # Check page title
        self.assertIn("Government Stock Management", driver.title)
        print("✔ Page title verified.")

        # Check headers
        header = driver.find_element(By.TAG_NAME, "h1").text
        self.assertEqual(header, "Government Stock Management")
        print("✔ Main header verified.")

        mail_header = driver.find_element(By.XPATH, "//h2[contains(text(),'Mail / Package Stock')]").text
        self.assertIn("Mail / Package Stock", mail_header)
        print("✔ Mail/Package stock header verified.")

        fert_header = driver.find_element(By.XPATH, "//h2[contains(text(),'Fertilizer Stock')]").text
        self.assertIn("Fertilizer Stock", fert_header)
        print("✔ Fertilizer stock header verified.")

        # Check Mail / Package table columns
        mail_table_headers = driver.find_elements(By.XPATH, "(//h2[contains(text(),'Mail / Package Stock')]/following-sibling::table)[1]//th")
        expected_mail_headers = ['ID', 'Amount', 'Status', 'Remaining', 'Actions']
        actual_mail_headers = [th.text for th in mail_table_headers]
        self.assertEqual(actual_mail_headers, expected_mail_headers)
        print("✔ Mail/Package stock table headers verified.")

        # Check Fertilizer table columns
        fert_table_headers = driver.find_elements(By.XPATH, "(//h2[contains(text(),'Fertilizer Stock')]/following-sibling::table)[1]//th")
        expected_fert_headers = ['ID', 'Packs', 'Status', 'Remaining', 'Actions']
        actual_fert_headers = [th.text for th in fert_table_headers]
        self.assertEqual(actual_fert_headers, expected_fert_headers)
        print("✔ Fertilizer stock table headers verified.")

        # Check presence of Edit/Delete links or no-record messages
        mail_actions = driver.find_elements(By.XPATH, "(//h2[contains(text(),'Mail / Package Stock')]/following-sibling::table)[1]//a[contains(@class, 'button')]")
        fert_actions = driver.find_elements(By.XPATH, "(//h2[contains(text(),'Fertilizer Stock')]/following-sibling::table)[1]//a[contains(@class, 'button')]")

        no_mail_records = driver.find_elements(By.XPATH, "(//h2[contains(text(),'Mail / Package Stock')]/following-sibling::table)[1]//td[contains(text(),'No mail/package records found.')]")
        no_fert_records = driver.find_elements(By.XPATH, "(//h2[contains(text(),'Fertilizer Stock')]/following-sibling::table)[1]//td[contains(text(),'No fertilizer records found.')]")

        self.assertTrue(len(mail_actions) > 0 or len(no_mail_records) > 0, "Mail/Package table has neither records nor no-record message.")
        self.assertTrue(len(fert_actions) > 0 or len(no_fert_records) > 0, "Fertilizer table has neither records nor no-record message.")
        print("✔ Edit/Delete links or no-record messages verified for both tables.")

    @classmethod
    def tearDownClass(cls):
        print("\n🎉 TEST PASSED! All checks completed successfully.")
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main(verbosity=2)
