
import java.sql.*;

public class Main {

    public static void main(String[] args) {
        try {
            //Connect To Server
            Boolean result;
            Class.forName("com.mysql.jdbc.Driver");
         //   Connection con = DriverManager.getConnection(
         //   "jdbc:mysql://dijkstra2.ug.bcc.bilkent.edu.tr/abdullah_al_wali","abdullah.al_wali","iak.7r81n");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost/abdullah_al_wali","root","");
            System.out.println("Connected");

            Statement stmt = con.createStatement();
            //Drop All Tables


            stmt.execute("DROP TABLE IF EXISTS guest_show ;");
            stmt.execute("DROP TABLE IF EXISTS guest ;");
            stmt.execute("DROP TABLE IF EXISTS `show` ;");
            stmt.execute("DROP TABLE IF EXISTS host ;");
            stmt.execute("DROP TABLE IF EXISTS channel ;");



            //Create Tables:
            stmt.execute("CREATE TABLE IF NOT EXISTS host(" +
                    "hid INT," +
                    " name VARCHAR(50)," +
                    " nickname VARCHAR(50)," +
                    " password VARCHAR(50)," +
                    " title VARCHAR(50)," +
                    " proffesion VARCHAR(50)," +
                    "PRIMARY KEY (hid) )ENGINE=InnoDB;");

            stmt.execute("CREATE TABLE IF NOT EXISTS channel (" +
                    " cid INT," +
                    "cname VARCHAR(50)," +
                    "PRIMARY KEY (cid) )ENGINE=InnoDB;");
            
            stmt.execute("CREATE TABLE IF NOT EXISTS `show`(" +
                    "sid INT," +
                    "pname VARCHAR(50)," +
                    "time TIME," +
                    "day VARCHAR(50)," +
                    "hid INT," +
                    "cid INT," +
                    "PRIMARY KEY (sid)," +
                    "FOREIGN KEY (hid) REFERENCES host(hid)," +
                    "FOREIGN KEY (cid) REFERENCES channel(cid) )ENGINE=InnoDB;");
            stmt.execute("CREATE TABLE IF NOT EXISTS guest(" +
                    "gid INT, " +
                    "gname VARCHAR(50)," +
                    "title VARCHAR(50)," +
                    "profession VARCHAR(50)," +
                    "short_bio VARCHAR(1000)," +
                    "PRIMARY KEY (gid) )ENGINE=InnoDB;");
            stmt.execute("CREATE TABLE If NOT EXISTS guest_show(" +
                    "gid INT," +
                    "sid INT," +
                    "date DATE," +
                    "PRIMARY KEY ( sid, gid, date)," +
                    "FOREIGN KEY (sid) REFERENCES `show`(sid)," +
                    "FOREIGN KEY (gid) REFERENCES guest(gid) )ENGINE=InnoDB;");


            //Insert Values
            stmt.execute("INSERT INTO host VALUES (1,'Fatih Altayli', 'altayli', '1111', 'Mr.' , 'journalist' );");
            stmt.execute("INSERT INTO host VALUES (2,'Cuneyt Ozdemir', 'ozdemir', '2222', 'Mr.' , 'journalist' );");
            stmt.execute("INSERT INTO host VALUES (3,'Neil deGrasse Tyson', 'tyson', '3333', 'Dr.' , 'astrophysicist' );");

            stmt.execute("INSERT INTO channel  VALUES (1, 'National Geographic');");
            stmt.execute("INSERT INTO channel  VALUES (2, 'CNN TURK');");
            stmt.execute("INSERT INTO channel  VALUES (3, 'Haberturk');");

            stmt.execute("INSERT INTO `show` VALUES (1, 'Teke Tek', '23:00:00', 'Tuesday', 1, 3);");
            stmt.execute("INSERT INTO `show` VALUES (2, '5N1K', '22:00:00', 'Sunday', 2, 2);");
            stmt.execute("INSERT INTO `show` VALUES (3, 'Startalk', '22:00:00', 'Monday', 3, 1);");

            stmt.execute("ALTER TABLE guest CONVERT TO CHARACTER SET utf8");
            stmt.execute("INSERT INTO guest VALUES (5, 'Celal Sengor' , 'Prof. Dr.', 'geologist' , 'Professor Sengor is" +
                    " a (foreign) member of The American Philosophical Society, The United States National Academy of" +
                    " Sciences and The Russian Academy of Sciences. Actually, he is the second Turkish prominent " +
                    "professor who is elected as a member by the Russian Academy of Sciences after Professor" +
                    " ordinarius Mehmet Fuat Koprulu.');");
            stmt.execute("INSERT INTO guest VALUES (6, 'Ilber Ortayli' , 'Prof. Dr.', 'historian' , 'İlber Ortayli" +
                    " is heir to a bilingual Turkish family so that he obtained German from his father and Russian" +
                    " from his mother. As a polyglot historian he has enough competency in Italian, English, French," +
                    " Persian and also in Ottoman Turkish and Latin in order to fluently employ or maintain " +
                    "historical research with historical documents why are you even reading this in the archives." +
                    " His published articles are mainly in Turkish, German and French and various of " +
                    "them are translated in English.');");
            stmt.execute("INSERT INTO guest VALUES (7, 'Mayim Bialik' , 'Mrs.', 'actress' , 'Mayim Chaya Bialik" +
                    " is an American actress and neuroscientist. From 1991 to 1995, she played the title character" +
                    " of NBC''s Blossom. Since 2010, she has played Dr. Amy Farrah Fowler – like the actress, " +
                    "a neuroscientist – on CBS''s The Big Bang Theory.');");
            stmt.execute("INSERT INTO guest VALUES (8, 'Orhan Pamuk' , 'Mr.', 'novelist' , 'Orhan Pamuk is a typical " +
                    "mainstream Turkish novelist, screenwriter, academic and recipient of the 2006 Nobel Prize in " +
                    "Literature. One of Turkey''s most prominent novelists, his work has sold over thirteen million" +
                    " books in sixty-three languages, making him the country''s best- selling writer.');");
            stmt.execute("INSERT INTO guest VALUES (9, 'Fazil Say' , 'Mr.', 'pianist' , 'Fazil Say is a virtuoso" +
                    " Turkish pianist and composer who was born in Ankara, described recently as \"not merely" +
                    " a pianist of genius; but undoubtedly he will be one of the great artists of the twenty-first century\".');");

            stmt.execute("INSERT INTO guest_show VALUES (5,1,'2016-11-22');");
            stmt.execute("INSERT INTO guest_show VALUES (6,1,'2016-11-22');");
            stmt.execute("INSERT INTO guest_show VALUES (7,3,'2016-11-21');");
            stmt.execute("INSERT INTO guest_show VALUES (8,2,'2016-11-27');");
            stmt.execute("INSERT INTO guest_show VALUES (9,2,'2016-11-27');");


            ResultSet resultSet = stmt.executeQuery("SELECT * from guest_show natural join guest natural join `show`;");
            ResultSetMetaData rsmd = resultSet.getMetaData();
            int columnsNumber = rsmd.getColumnCount();
            while (resultSet.next()) {
                for (int i = 1; i <= columnsNumber; i++) {
                    if (i > 1) System.out.print(",  ");
                    String columnValue = resultSet.getString(i);
                    System.out.print(columnValue + " " + rsmd.getColumnName(i));
                }
                System.out.println("");
            }





        } catch (SQLDataException ex) {
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
            System.out.println("!Connected");

        } catch (Exception ex) {
            // handle any errors
            System.out.println("!Connected");
            System.out.println("Exception: " + ex.getMessage());

        }
    }
}
