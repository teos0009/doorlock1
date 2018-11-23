using System;
using System.Security.Cryptography;
using System.Text;

namespace Library.Class
{
    public class Hash
    {
        public static string Hasher(string Input)
        {
            var provider = MD5.Create();
            Random rdm = new Random();
            int ranno = rdm.Next(0, 10000);
            string Salt = "V3ryS3cureS4lt";
            byte[] bytes = provider.ComputeHash(Encoding.ASCII.GetBytes(ranno + Salt + Input));
            string computedHash = BitConverter.ToString(bytes);
            computedHash = computedHash.Replace("-", "").Substring(0,6);
            return computedHash;
        }
    }
}
