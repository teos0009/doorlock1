using Library.Class;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System;

namespace Test.Pages
{
    public class LecturerPageModel : PageModel
    {
        [BindProperty]
        public string dateTime { get; set; }
        [BindProperty]
        public string OTP { get; set; }

        public IActionResult OnPost()
        {
            string temp = dateTime.Replace(",", string.Empty);
            string hash = Hash.Hasher(temp);
            OTP = hash;
            SQL.Input(temp, hash);
            return RedirectToPage("Success", "Message", new { msg = OTP });
        }
        
    }
}