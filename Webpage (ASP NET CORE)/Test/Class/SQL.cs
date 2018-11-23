using Dapper;
using Library.Object;
using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Text;

namespace Library.Class
{
    public class SQL
    {
        public static MySqlConnection Connection= new MySqlConnection("server=127.0.0.1;database=doorlock;uid=SPortal;pwd=Weipassword;charset='gbk';SslMode=None");

        public static void Input(string Time, string Key)
        {
            using (MySqlConnection con = Connection)
            {
                con.Execute($"INSERT INTO `doorlock`.`lock`(`Date`, `Key`) VALUES('{Time}','{Key}');");
            }
        }

        public static bool Verification(string Time, string Key)
        {
            using (MySqlConnection con = Connection)
            {
                List<LockEntry> Field= (List<LockEntry>)con.Query<LockEntry>($"SELECT * FROM `doorlock`.`lock` WHERE `Key`='{Key}';");
                if (Field.Count > 0)
                {
                    DateTime EntryTime = DateTime.Parse(Time);
                    DateTime GenTime = DateTime.Parse(Field[0].Date);
                    TimeSpan Diff = EntryTime - GenTime;
                    if (Diff.Seconds <= 60 && Diff.Seconds >= -60)
                    {
                        con.Execute($"DELETE FROM `doorlock`.`lock` WHERE `ID`={Field[0].ID};");
                        return true;
                    }
                }
            }
            return false;
        }
    }
}
