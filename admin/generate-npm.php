<?php

session_start();

require_once '../config/connect.php';


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['admin_logged_in']) ||
   $_SESSION['admin_logged_in'] !== true ||
   empty($_SESSION['admin_user_id'])
) {
   header('Location: ./index.php');
   exit;
}


/**
 * =========================================================
 * REDIRECT
 * =========================================================
 */

function redirectBack(
   string $type,
   string $message
): void {

   header(
      'Location: ./daftar-ulang.php?'
         . $type
         . '='
         . urlencode($message)
   );

   exit;
}


/**
 * =========================================================
 * GET ID
 * =========================================================
 */

$id = filter_input(
   INPUT_GET,
   'id',
   FILTER_VALIDATE_INT
);


if (
   !$id ||
   $id < 1
) {

   redirectBack(
      'error',
      'ID peserta tidak valid.'
   );
}


/**
 * =========================================================
 * TRANSACTION
 * =========================================================
 */

try {

   $pdo->beginTransaction();


   /**
    * =====================================================
    * 1. AMBIL DATA PESERTA
    * =====================================================
    *
    * Sekalian JOIN:
    *
    * register_pmb
    *      ↓
    * ms_program_studi
    *      ↓
    * ms_collage
    *
    */

   $stmt = $pdo->prepare("

        SELECT

            rp.id,
            rp.register_uid,
            rp.fullname,
            rp.gender,
            rp.agama,
            rp.place,
            rp.datebirth,

            rp.phone_number,
            rp.email_register,
            rp.address_card,

            rp.provinsi,
            rp.kabupaten,
            rp.kecamatan,
            rp.kelurahan,

            rp.emergency_name,
            rp.emergency_phone,
            rp.emergency_relasi,

            rp.register_type,
            rp.id_program,
            rp.created_at,

            rp.status_pendaftaran,
            rp.status_kelulusan,

            rp.npm_sementara,
            rp.nim,

            ps.program_name,
            ps.program_code,
            ps.id_collage,

            mc.collage_name,
            mc.college_code

        FROM register_pmb rp

        INNER JOIN ms_program_studi ps

            ON ps.id_program = rp.id_program

        LEFT JOIN ms_collage mc

            ON mc.id_collage =
               CAST(ps.id_collage AS UNSIGNED)

        WHERE rp.id = :id

        LIMIT 1

        FOR UPDATE

    ");


   $stmt->execute([
      'id' => $id
   ]);


   $peserta =
      $stmt->fetch(
         PDO::FETCH_ASSOC
      );


   if (!$peserta) {

      throw new Exception(
         'Peserta PMB tidak ditemukan.'
      );
   }


   /**
    * =====================================================
    * 2. VALIDASI STATUS
    * =====================================================
    */

   $statusPendaftaran =
      strtoupper(
         trim(
            (string)
            ($peserta['status_pendaftaran'] ?? '')
         )
      );


   $statusKelulusan =
      strtoupper(
         trim(
            (string)
            ($peserta['status_kelulusan'] ?? '')
         )
      );


   $statusValid =

      $statusKelulusan === 'LULUS'

      ||

      in_array(
         $statusPendaftaran,
         [
            'DAFTAR_ULANG',
            'MAHASISWA'
         ],
         true
      );


   if (!$statusValid) {

      throw new Exception(
         'Peserta belum berada pada tahap yang dapat diberikan NPM.'
      );
   }


   /**
    * =====================================================
    * 3. CEK NPM LAMA
    * =====================================================
    */

   $npmExisting =
      trim(
         (string)
         ($peserta['npm_sementara'] ?? '')
      );


   if ($npmExisting !== '') {

      throw new Exception(
         'Peserta ini sudah memiliki NPM: '
            . $npmExisting
      );
   }


   /**
    * =====================================================
    * 4. VALIDASI COLLEGE CODE
    * =====================================================
    *
    * NPM menggunakan:
    *
    * ms_collage.college_code
    *
    */


   $collegeCode =
      trim(
         (string)
         ($peserta['college_code'] ?? '')
      );


   if ($collegeCode === '') {

      throw new Exception(
         'College code belum tersedia pada ms_collage untuk program studi '
            . $peserta['program_name']
            . '.'
      );
   }


   /**
    * =====================================================
    * NORMALISASI COLLEGE CODE
    * =====================================================
    *
    * Misalnya:
    *
    * 69
    * 01
    * 1
    *
    */


   $collegeCode =
      str_pad(
         $collegeCode,
         2,
         '0',
         STR_PAD_LEFT
      );


   /**
    * =====================================================
    * 5. VALIDASI PROGRAM CODE
    * =====================================================
    */


   $programCode =
      trim(
         (string)
         ($peserta['program_code'] ?? '')
      );


   if ($programCode === '') {

      throw new Exception(
         'Program code belum tersedia untuk program studi '
            . $peserta['program_name']
            . '.'
      );
   }


   /**
    * Ambil 2 digit pertama.
    *
    * Sama seperti SQL lama:
    *
    * LEFT(program_code, 2)
    */

   $programCode =
      substr(
         $programCode,
         0,
         2
      );


   $programCode =
      str_pad(
         $programCode,
         2,
         '0',
         STR_PAD_LEFT
      );


   /**
    * =====================================================
    * 6. TAHUN MASUK
    * =====================================================
    *
    * created_at:
    *
    * 2026-09-25
    *
    * menjadi:
    *
    * 26
    *
    */


   $tahunMasuk =
      (int)
      date(
         'Y',
         strtotime(
            $peserta['created_at']
         )
      );


   $tahunCode =
      substr(
         (string)$tahunMasuk,
         -2
      );


   /**
    * =====================================================
    * 7. KODE TIPE MAHASISWA
    * =====================================================
    *
    * reguler   = 01
    * eksekutif = 02
    * pindahan  = 03
    */


   $registerType =
      strtolower(
         trim(
            (string)
            ($peserta['register_type'] ?? '')
         )
      );


   switch ($registerType) {

      case 'reguler':

         $kodeTipe = '01';

         break;


      /**
       * Reguler Sore & Eksekutif sama-sama memakai kode 02.
       */
      case 'reguler sore':
      case 'eksekutif':

         $kodeTipe = '02';

         break;


      case 'pindahan':

         $kodeTipe = '03';

         break;


      default:

         throw new Exception(
            'Jenis pendaftaran tidak dikenali: '
               . $peserta['register_type']
         );
   }


   /**
    * =====================================================
    * 8. PREFIX NPM
    * =====================================================
    *
    * YY
    * +
    * COLLEGE CODE
    * +
    * PROGRAM CODE
    * +
    * TIPE
    *
    */


   $prefix =

      $tahunCode

      . $collegeCode

      . $programCode

      . $kodeTipe;


   /**
    * Contoh:
    *
    * 26
    * 69
    * 01
    * 01
    *
    * = 26690101
    */


   /**
    * =====================================================
    * PREFIX NOMOR URUT
    * =====================================================
    *
    * Nomor urut 4 digit terakhir berlanjut untuk semua
    * jenis pendaftaran (01 / 02 / 03) dalam
    * tahun + kampus + prodi yang sama.
    *
    * Contoh:
    *   26 69 01 01 0050  (REGULER)
    *   26 69 01 02 0051  (EKSEKUTIF) -> lanjut, bukan 0001
    *
    * Karena itu kode tipe TIDAK ikut dalam pencarian
    * nomor urut, hanya YY + COLLEGE + PROGRAM.
    */

   $prefixUrut =
      $tahunCode
      . $collegeCode
      . $programCode;

   $panjangNpm =
      strlen($prefix) + 4;


   /**
    * =====================================================
    * 9. CARI NOMOR URUT DI register_pmb
    * =====================================================
    */


   $stmtMaxRegister = $pdo->prepare("

        SELECT

            MAX(
                CAST(
                    RIGHT(
                        TRIM(npm_sementara),
                        4
                    )
                    AS UNSIGNED
                )
            ) AS max_urut

        FROM register_pmb

        WHERE npm_sementara IS NOT NULL

          AND TRIM(npm_sementara) <> ''

          AND CHAR_LENGTH(TRIM(npm_sementara)) = :npm_length

          AND TRIM(npm_sementara) REGEXP '^[0-9]+$'

          AND LEFT(
                TRIM(npm_sementara),
                :prefix_length
              ) = :prefix

    ");


   $stmtMaxRegister->execute([

      'npm_length' =>
      $panjangNpm,

      'prefix_length' =>
      strlen($prefixUrut),

      'prefix' =>
      $prefixUrut

   ]);


   $maxUrutRegister =
      (int)
      (
         $stmtMaxRegister
         ->fetchColumn()
         ?: 0
      );


   /**
    * =====================================================
    * 10. CARI NOMOR URUT DI ms_student
    * =====================================================
    */


   $stmtMaxStudent = $pdo->prepare("

        SELECT

            MAX(
                CAST(
                    RIGHT(
                        TRIM(student_npm),
                        4
                    )
                    AS UNSIGNED
                )
            ) AS max_urut

        FROM ms_student

        WHERE student_npm IS NOT NULL

          AND TRIM(student_npm) <> ''

          AND CHAR_LENGTH(TRIM(student_npm)) = :npm_length

          AND TRIM(student_npm) REGEXP '^[0-9]+$'

          AND LEFT(
                TRIM(student_npm),
                :prefix_length
              ) = :prefix

    ");


   $stmtMaxStudent->execute([

      'npm_length' =>
      $panjangNpm,

      'prefix_length' =>
      strlen($prefixUrut),

      'prefix' =>
      $prefixUrut

   ]);


   $maxUrutStudent =
      (int)
      (
         $stmtMaxStudent
         ->fetchColumn()
         ?: 0
      );


   /**
    * =====================================================
    * 10b. NPM TERTINGGI DARI SETTING NPM
    * =====================================================
    *
    * Diatur admin pada menu Setting NPM
    * (admin/setting-npm.php) per program studi.
    *
    * Hanya dipakai jika tahun + kampus + prodi
    * pada NPM setting sama dengan prefix peserta.
    */

   $maxUrutSetting = 0;

   try {

      $stmtSetting = $pdo->prepare("

           SELECT npm_tertinggi

           FROM setting_npm

           WHERE id_program = :id_program

           LIMIT 1

       ");

      $stmtSetting->execute([
         'id_program' =>
         $peserta['id_program']
      ]);

      $npmSetting =
         trim(
            (string)
            ($stmtSetting->fetchColumn() ?: '')
         );

      if (
         strlen($npmSetting) === $panjangNpm
         && ctype_digit($npmSetting)
         && strpos($npmSetting, $prefixUrut) === 0
      ) {

         $maxUrutSetting =
            (int) substr($npmSetting, -4);
      }
   } catch (PDOException $e) {

      /**
       * Tabel setting_npm belum dibuat
       * (menu Setting NPM belum pernah dibuka).
       */

      $maxUrutSetting = 0;
   }


   /**
    * =====================================================
    * 11. NOMOR BERIKUTNYA
    * =====================================================
    */


   $nomorUrut =

      max(
         $maxUrutRegister,
         $maxUrutStudent,
         $maxUrutSetting
      )

      + 1;


   if ($nomorUrut > 9999) {

      throw new Exception(
         'Nomor urut NPM sudah mencapai batas 9999.'
      );
   }


   /**
    * =====================================================
    * 12. FORMAT 4 DIGIT
    * =====================================================
    */


   $suffix =
      str_pad(
         (string)$nomorUrut,
         4,
         '0',
         STR_PAD_LEFT
      );


   /**
    * =====================================================
    * 13. NPM BARU
    * =====================================================
    */


   $npmBaru =
      $prefix
      . $suffix;


   /**
    * =====================================================
    * 14. CEK DUPLIKAT FINAL
    * =====================================================
    */


   $stmtDuplicate = $pdo->prepare("

        SELECT COUNT(*)

        FROM ms_student

        WHERE TRIM(student_npm) = :npm

    ");


   $stmtDuplicate->execute([

      'npm' =>
      $npmBaru

   ]);


   if (
      (int)
      $stmtDuplicate->fetchColumn()
      > 0
   ) {

      throw new Exception(
         'NPM '
            . $npmBaru
            . ' sudah digunakan oleh mahasiswa lain.'
      );
   }


   /**
    * =====================================================
    * 15. UPDATE register_pmb
    * =====================================================
    */


   $stmtUpdate =
      $pdo->prepare("

            UPDATE register_pmb

            SET

                npm_sementara = :npm,

                updated_at = NOW()

            WHERE id = :id

              AND (
                    npm_sementara IS NULL
                    OR TRIM(npm_sementara) = ''
              )

            LIMIT 1

        ");


   $stmtUpdate->execute([

      'npm' =>
      $npmBaru,

      'id' =>
      $peserta['id']

   ]);


   if (
      $stmtUpdate->rowCount() !== 1
   ) {

      throw new Exception(
         'NPM gagal disimpan ke register_pmb.'
      );
   }


   /**
    * =====================================================
    * 16. INSERT ms_student
    * =====================================================
    */


   $stmtStudent =
      $pdo->prepare("

            INSERT INTO ms_student (

                student_npm,
                student_name,
                student_gender,
                student_religion,

                student_tempatlahir,
                student_tanggallahir,

                student_phone,
                student_mail,
                student_address,

                student_status,
                student_year,

                id_program_studi,
                student_category,

                student_provinsi,
                student_kabupaten,
                student_kecamatan,
                student_desa,

                student_emergency_name,
                student_emergency_phone,
                student_emergency_relasi,

                student_tipe_mahasiswa,
                student_session,
                student_active_class

            )

            VALUES (

                :student_npm,
                :student_name,
                :student_gender,
                :student_religion,

                :student_tempatlahir,
                :student_tanggallahir,

                :student_phone,
                :student_mail,
                :student_address,

                1,
                :student_year,

                :id_program_studi,
                2,

                :student_provinsi,
                :student_kabupaten,
                :student_kecamatan,
                :student_desa,

                :student_emergency_name,
                :student_emergency_phone,
                :student_emergency_relasi,

                :student_tipe_mahasiswa,
                :student_session,
                1

            )

        ");


   $stmtStudent->execute([

      'student_npm' =>
      $npmBaru,

      'student_name' =>
      $peserta['fullname'],

      'student_gender' =>
      $peserta['gender'],

      'student_religion' =>
      $peserta['agama'],

      'student_tempatlahir' =>
      $peserta['place'],

      'student_tanggallahir' =>
      $peserta['datebirth'],

      'student_phone' =>
      $peserta['phone_number'],

      'student_mail' =>
      $peserta['email_register'],

      'student_address' =>
      $peserta['address_card'],

      'student_year' =>
      $tahunMasuk,

      'id_program_studi' =>
      $peserta['id_program'],

      'student_provinsi' =>
      $peserta['provinsi'],

      'student_kabupaten' =>
      $peserta['kabupaten'],

      'student_kecamatan' =>
      $peserta['kecamatan'],

      'student_desa' =>
      $peserta['kelurahan'],

      'student_emergency_name' =>
      $peserta['emergency_name'],

      'student_emergency_phone' =>
      $peserta['emergency_phone'],

      'student_emergency_relasi' =>
      $peserta['emergency_relasi'],

      /**
       * Di SIAKAD: student_tipe_mahasiswa 1 = Reguler, 2 = Transfer.
       * Jangan isi dengan kode tengah NPM (01/02/03), karena '02'
       * (Eksekutif) akan terbaca sebagai Transfer.
       */
      'student_tipe_mahasiswa' =>
      $kodeTipe === '03' ? '2' : '1',

      /**
       * student_session: 1 = Reguler Pagi, 2 = Reguler Sore A.
       * Kode 02 (Reguler Sore / Eksekutif) masuk jadwal sore.
       */
      'student_session' =>
      $kodeTipe === '02' ? 2 : 1

   ]);


   /**
    * =====================================================
    * 17. CREATE USER
    * =====================================================
    *
    * Pola lama:
    *
    * username = nim
    * password = phone
    *
    * Kalau nim kosong:
    *
    * username = NPM
    */


   $username =
      trim(
         (string)
         ($peserta['nim'] ?? '')
      );


   if ($username === '') {

      $username =
         $npmBaru;
   }


   $phone =
      trim(
         (string)
         ($peserta['phone_number'] ?? '')
      );


   if ($phone === '') {

      throw new Exception(
         'Nomor HP peserta kosong. Akun mahasiswa tidak dapat dibuat.'
      );
   }


   /**
    * Cek user berdasarkan username
    */


   $stmtUserCheck =
      $pdo->prepare("

            SELECT COUNT(*)

            FROM ms_user

            WHERE username = :username

        ");


   $stmtUserCheck->execute([

      'username' =>
      $username

   ]);


   $userExists =
      (int)
      $stmtUserCheck->fetchColumn();


   if ($userExists === 0) {

      $stmtUser =
         $pdo->prepare("

                INSERT INTO ms_user (

                    uid,
                    fullname,
                    username,
                    password,
                    roles,
                    path,
                    status,
                    create_at,
                    id_program,
                    id_collage

                )

                VALUES (

                    :uid,
                    :fullname,
                    :username,
                    :password,

                    'student',
                    'student',

                    1,
                    NOW(),

                    :id_program,
                    :id_collage

                )

            ");


      $stmtUser->execute([

         'uid' =>
         $peserta['register_uid'],

         'fullname' =>
         $peserta['fullname'],

         'username' =>
         $username,

         'password' =>
         $phone,

         'id_program' =>
         $peserta['id_program'],

         'id_collage' =>
         $peserta['id_collage']

      ]);
   }


   /**
    * =====================================================
    * 18. COMMIT
    * =====================================================
    */


   $pdo->commit();


   /**
    * =====================================================
    * 19. SUCCESS
    * =====================================================
    */


   redirectBack(
      'success',
      'NPM '
         . $npmBaru
         . ' berhasil dibuat untuk '
         . $peserta['fullname']
         . '. Data mahasiswa dan akun berhasil dibuat.'
   );
} catch (
   Throwable $e
) {


   /**
    * =====================================================
    * ROLLBACK
    * =====================================================
    */

   if (
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   redirectBack(
      'error',
      $e->getMessage()
   );
}
