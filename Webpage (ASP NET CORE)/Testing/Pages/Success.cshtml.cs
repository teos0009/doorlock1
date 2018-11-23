using Library.Class;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System;

namespace Test.Pages
{
    public class SuccessModel : PageModel
    {
        [BindProperty]
        public string Message { get; set; }

        public void OnGetMessage(string msg)
        {
            Message = msg;
        }

        
    }
}