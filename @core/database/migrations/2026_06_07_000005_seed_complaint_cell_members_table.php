<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedComplaintCellMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        $central = [
            ['Mr. Md Rezaul Karim', 'Deputy Managing Director', 'Head of Complaint Cell', "Contact: 01991144104\nEmail: rezaulkarim@uttarabank-bd.com"],
            ['Mr. Khandaker Ali Samnoon', 'Deputy Managing Director', 'Deputy Head of Complaint Cell', "Mobile: 01911440022\nEmail: id@uttarabank-bd.com"],
            ['Mr. Md. Mizanur Rahman', 'General Manager', '', "Mobile: 01991144015\nEmail: bccsd@uttarabank-bd.com"],
            ['Md. Shah Muazzem Hossain', 'Deputy General Manager', 'Member Secretary', "Mobile: 01991144076\nEmail: bccsd.ccscmc@uttarabank-bd.com"],
        ];

        $rows = [];
        foreach ($central as $index => $member) {
            $rows[] = [
                'section' => 'central',
                'zone_name' => null,
                'name' => $member[0],
                'designation' => $member[1],
                'position' => $member[2],
                'contact' => $member[3],
                'sort_order' => $index,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $zones = [
            'Barishal Zone' => [
                ['Mr. Abul kalam Sarker', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01991144415'],
                ['Mr. Md. Ferdous Rahman', 'Assistant General Manager', 'Member', '01717590480'],
                ['Mr. Sharif Ashraful Alam', 'Principal Officer', 'Member', '01711440787'],
            ],
            'Bogura Zone' => [
                ['Mr. Alok Kumar Saha', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01991144355'],
                ['Mr. Md. Farid Hossain', 'Senior Principal Officer', 'Member', '01716550126'],
                ['Mr. Jahangir Alam', 'Principal Officer', 'Member', '01983614675'],
            ],
            'Chattogram Zone' => [
                ['Mr. Anwar Hossain', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01991144265'],
                ['Mr. Md. Zahid Hossain Majumder', 'Assistant General Manager', 'Member', '01711892438'],
                ['Mr. Mohammad Yousuf', 'Assistant General Manager', 'Member', '02-33331253'],
            ],
            'Corporate Branch' => [
                ['Mr. Md. Monowarul Haque', 'General Manager', 'Head of Cell', '01991144495'],
                ['Mr. Niren Chandra Das', 'Deputy General Manager', 'Member', '01991144496'],
                ['Mr. Md. Bazlur Rahman', 'Senior Principal Officer', 'Member', '01991144497'],
            ],
            'Cumilla Zone' => [
                ['Mr. Md. Jahangir Alam', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01991144300'],
                ['Mr. Mohammad Ali Azad Khan', 'Senior Principal Officer', 'Member', '01761097659'],
                ['Mr. Md. Shahidul Islam Mazumder', 'Senior Officer', 'Member', '01817069484'],
            ],
            'Dhaka Central Zone' => [
                ['Md. Mohammad Liton Pasa Khan', 'General Manager & Zonal Head', 'Head of Cell', '01745807030'],
                ['Mr. Mohammad Abul Kalam Chowdhury', 'Assistant General Manager', 'Member', '01714208929'],
                ['Mr. Dulal Kumar Mondal', 'Senior Principal Officer', 'Member', '01711870041'],
            ],
            'Dhaka North Zone' => [
                ['Mr. Madhu Sudan Sardar', 'General Manager & Zonal Head', 'Head of Cell', '01991144150'],
                ['Mr. Md. Humayun Kabir', 'Assistant General Manager', 'Member', '01619230191'],
                ['Mr. Muhammad Kamrul Hasan', 'Senior Principal Officer', 'Member', '01972172960'],
            ],
            'Dhaka South Zone' => [
                ['Mr. Mohammed Rafiq Newaz', 'General Manager & Zonal Head', 'Head of Cell', '01991144190'],
                ['Mr. Kazi Masum Zakaria', 'Assistant General Manager', 'Member', '01911231535'],
                ['Mr. Atiqur Rahman', 'Principal Officer', 'Member', ''],
            ],
            'Khulna Zone' => [
                ['Mr. Md. Mostafizur Rahman', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01712272597'],
                ['Mr. Mohammad Abdulla Hel Baki', 'Assistant General Manager', 'Member', '01716174522'],
                ['Mrs. Joya Podder', 'Principal Officer', 'Member', '01680154201'],
            ],
            'Local Office' => [
                ['Mr. Md. Abdul Khaleque Miah', 'General Manager', 'Head of Cell', '01991144485'],
                ['Mr. Muhammad Shahidul Islam', 'Assistant General Manager', 'Member', '01991144033'],
                ['Mr. Md. Abul Kalam', 'Assistant General Manager', 'Member', '01720104387'],
            ],
            'Mymensingh Zone' => [
                ['Mr. Mohammad Mozammel Hoque', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01711284177'],
                ['Mr. A. K. M. Nuruzzaman Bhuyan', 'Senior Principal Officer', 'Member', '01710420301'],
                ['Mr. Sheikh Mehebub Hasan', 'Senior Principal Officer', 'Member', '01717000432'],
            ],
            'Narayangonj Zone' => [
                ['Mr. Md. Atiqur Rahman', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01991144220'],
                ['Mr. Bazlur Rashid', 'Senior Principal Officer', 'Member', '01724906050'],
                ['Mr. Md. Arifur Rahman Chowdhury', 'Senior Officer', 'Member', '01913827189'],
            ],
            'Rajshahi Zone' => [
                ['Mr. Alok Kumar Saha', 'Deputy General Manager & Zonal Head', 'Cell Head', '01991144335'],
                ['Mr. Md. Hasanuzzaman', 'Senior Principal Officer', 'Member', '01740192107'],
            ],
            'Sylhet Zone' => [
                ['Mr. Mohiuddin Ahmed', 'Deputy General Manager & Zonal Head', 'Head of Cell', '01991144450'],
                ['Mr. Arup Kumar Talukdar', 'Senior Principal Officer', 'Member', '01772959624'],
                ['Mr. Md. Shahed Hasan Ripoyon', 'Senior Principal Officer', 'Member', '01716176033'],
            ],
        ];

        $sort_order = 0;
        foreach ($zones as $zone_name => $members) {
            foreach ($members as $member) {
                $rows[] = [
                    'section' => 'zonal',
                    'zone_name' => $zone_name,
                    'name' => $member[0],
                    'designation' => $member[1],
                    'position' => $member[2],
                    'contact' => $member[3],
                    'sort_order' => $sort_order,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $sort_order++;
            }
        }

        DB::table('complaint_cell_members')->insert($rows);

        update_static_option('complaint_cell_bank_name', 'Uttara Bank PLC.');
        update_static_option('complaint_cell_email', 'bccsd.ccscmc@uttarabank-bd.com');
        update_static_option('complaint_cell_phone', '02223388941');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('complaint_cell_members')->truncate();
    }
}
