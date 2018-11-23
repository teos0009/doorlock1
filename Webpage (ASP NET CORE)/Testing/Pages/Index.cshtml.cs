using Library.Class;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System;

namespace Test.Pages
{
    public class IndexModel : PageModel
    {
        [BindProperty]
        public string OTP { get; set; }

        public void OnGet()
        {
            MQTT.Init();
        }
        public IActionResult OnPostSubmit()
        {
            string Reply = "";
            bool Veri = SQL.Verification(DateTime.Now.ToString("ddd, dd MMM yyyy HH:mm:ss 'GMT'"), OTP);
            if (Veri == true)
            {
                MQTT.Publish();
            Reply = "Success";
        }
            else Reply = "Incorrect OTP";

            return RedirectToPage("Success", "Message", new { msg = Reply
    });
        }

        
    }
}