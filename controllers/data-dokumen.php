<?php

/**
 * =========================================================
 * CONTROLLER : DATA & DOKUMEN PMB
 * =========================================================
 *
 * INSERT / UPDATE
 * Table : register_pmb
 *
 * Authentication :
 * $_SESSION['pmb_user_id']
 *
 * =========================================================
 */

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/connect.php';



/**
 * =========================================================
 * RESPONSE
 * =========================================================
 */

function responseJson(
   bool $success,
   string $message,
   array $data = [],
   int $statusCode = 200
): void {

   http_response_code($statusCode);

   echo json_encode([
      'success' => $success,
      'message' => $message,
      'data'    => $data
   ], JSON_UNESCAPED_UNICODE);

   exit;
}


/**
 * =========================================================
 * AUTH CHECK
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   responseJson(
      false,
      'Sesi login telah berakhir. Silakan login kembali.',
      [
         'redirect' => '../login-pmb'
      ],
      401
   );
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * ONLY POST
 * =========================================================
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

   responseJson(
      false,
      'Method tidak diizinkan.',
      [],
      405
   );
}


/**
 * =========================================================
 * AMBIL USER
 * =========================================================
 */

try {

   $stmt = $pdo->prepare("
        SELECT *
        FROM register_pmb
        WHERE id = :id
        LIMIT 1
    ");

   $stmt->execute([
      'id' => $userId
   ]);

   $user = $stmt->fetch(PDO::FETCH_ASSOC);


   if (!$user) {

      responseJson(
         false,
         'Data peserta tidak ditemukan.',
         [],
         404
      );
   }
} catch (PDOException $e) {

   responseJson(
      false,
      'Gagal mengambil data peserta.',
      [],
      500
   );
}


/**
 * =========================================================
 * DATA FORM
 * =========================================================
 */

$fullname = trim(
   $_POST['nama'] ?? ''
);

$nik = preg_replace(
   '/[^0-9]/',
   '',
   trim($_POST['nik'] ?? '')
);

$genderInput =
   trim($_POST['jenis_kelamin'] ?? '');

$place = trim(
   $_POST['tempat_lahir'] ?? ''
);

$datebirth =
   trim($_POST['tanggal_lahir'] ?? '');

$agama = trim($_POST['agama'] ?? '');

$ukuranBaju = trim(
   $_POST['ukuran_baju'] ?? ''
);

$id_program = trim(
   $_POST['id_program'] ?? ''
);

$nameMother =
   trim($_POST['nama_ibu'] ?? '');

$yearGraduation =
   trim($_POST['tahun_lulus'] ?? '');

$phone =
   trim($_POST['no_hp'] ?? '');

$email =
   strtolower(
      trim($_POST['email'] ?? '')
   );

$address =
   trim($_POST['alamat'] ?? '');

$kelurahan =
   trim($_POST['kelurahan'] ?? '');

$kecamatan =
   trim($_POST['kecamatan'] ?? '');

$kabupaten =
   trim($_POST['kabupaten'] ?? '');

$provinsi =
   trim($_POST['provinsi'] ?? '');

$numberKip =
   trim($_POST['nomor_kip'] ?? '');


/**
 * =========================================================
 * PEMBIAYAAN
 *
 * Tidak disimpan karena kolom tidak tersedia
 * di register_pmb.
 * =========================================================
 */

$jenisPembiayaan =
   trim($_POST['jenis_pembiayaan'] ?? '');


/**
 * =========================================================
 * VALIDASI
 * =========================================================
 */

if ($fullname === '') {

   responseJson(
      false,
      'Nama lengkap wajib diisi.',
      ['field' => 'nama'],
      422
   );
}


if ($nik === '' || strlen($nik) !== 16) {

   responseJson(
      false,
      'NIK harus terdiri dari 16 digit.',
      ['field' => 'nik'],
      422
   );
}


/**
 * Gender
 *
 * Form:
 * L / P
 *
 * Database:
 * Laki-laki / Perempuan
 */

if ($genderInput === 'L') {

   $gender = 'Laki-laki';
} elseif ($genderInput === 'P') {

   $gender = 'Perempuan';
} else {

   responseJson(
      false,
      'Jenis kelamin wajib dipilih.',
      ['field' => 'jenis_kelamin'],
      422
   );
}

if ($agama === '') {

   responseJson(
      false,
      'Agama wajib dipilih.',
      ['field' => 'agama'],
      422
   );
}

if ($id_program === '') {

   responseJson(
      false,
      'Program Studi wajib dipilih.',
      ['field' => 'id_program'],
      422
   );
}


$allowedUkuranBaju = [
   'S',
   'M',
   'L',
   'XL',
   'XXL'
];

if (
   !in_array(
      $ukuranBaju,
      $allowedUkuranBaju,
      true
   )
) {

   responseJson(
      false,
      'Ukuran baju wajib dipilih.',
      ['field' => 'ukuran_baju'],
      422
   );
}


if ($place === '') {

   responseJson(
      false,
      'Tempat lahir wajib diisi.',
      ['field' => 'tempat_lahir'],
      422
   );
}


if ($datebirth === '') {

   responseJson(
      false,
      'Tanggal lahir wajib diisi.',
      ['field' => 'tanggal_lahir'],
      422
   );
}


/**
 * Validasi tanggal
 */

$dateObject =
   DateTime::createFromFormat(
      'Y-m-d',
      $datebirth
   );

if (
   !$dateObject ||
   $dateObject->format('Y-m-d') !== $datebirth
) {

   responseJson(
      false,
      'Format tanggal lahir tidak valid.',
      ['field' => 'tanggal_lahir'],
      422
   );
}


if ($nameMother === '') {

   responseJson(
      false,
      'Nama ibu kandung wajib diisi.',
      ['field' => 'nama_ibu'],
      422
   );
}


if (
   $yearGraduation === '' ||
   !preg_match('/^[0-9]{4}$/', $yearGraduation)
) {

   responseJson(
      false,
      'Tahun lulus tidak valid.',
      ['field' => 'tahun_lulus'],
      422
   );
}


if ($phone === '') {

   responseJson(
      false,
      'Nomor HP wajib diisi.',
      ['field' => 'no_hp'],
      422
   );
}


/**
 * Normalisasi nomor HP
 */

$phone = preg_replace(
   '/[^0-9+]/',
   '',
   $phone
);

if (str_starts_with($phone, '+62')) {

   $phone =
      '0' . substr($phone, 3);
} elseif (str_starts_with($phone, '62')) {

   $phone =
      '0' . substr($phone, 2);
}

$phone =
   preg_replace('/[^0-9]/', '', $phone);


if (
   strlen($phone) < 10 ||
   strlen($phone) > 15
) {

   responseJson(
      false,
      'Nomor HP tidak valid.',
      ['field' => 'no_hp'],
      422
   );
}


if (
   $email === '' ||
   !filter_var(
      $email,
      FILTER_VALIDATE_EMAIL
   )
) {

   responseJson(
      false,
      'Email tidak valid.',
      ['field' => 'email'],
      422
   );
}


if ($address === '') {

   responseJson(
      false,
      'Alamat wajib diisi.',
      ['field' => 'alamat'],
      422
   );
}


if ($kelurahan === '') {

   responseJson(
      false,
      'Kelurahan wajib diisi.',
      ['field' => 'kelurahan'],
      422
   );
}


if ($kecamatan === '') {

   responseJson(
      false,
      'Kecamatan wajib diisi.',
      ['field' => 'kecamatan'],
      422
   );
}


if ($kabupaten === '') {

   responseJson(
      false,
      'Kabupaten/Kota wajib diisi.',
      ['field' => 'kabupaten'],
      422
   );
}


if ($provinsi === '') {

   responseJson(
      false,
      'Provinsi wajib diisi.',
      ['field' => 'provinsi'],
      422
   );
}


/**
 * =========================================================
 * FILE UPLOAD
 * =========================================================
 */

$uploadDir =
   __DIR__ . '/../uploads/pmb/';


if (!is_dir($uploadDir)) {

   mkdir(
      $uploadDir,
      0755,
      true
   );
}


/**
 * Fungsi upload
 */

function uploadDocument(
   string $field,
   string $prefix,
   string $uploadDir,
   array $allowedExtensions
): ?string {

   if (
      !isset($_FILES[$field]) ||
      $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE
   ) {

      return null;
   }


   if (
      $_FILES[$field]['error'] !== UPLOAD_ERR_OK
   ) {

      responseJson(
         false,
         "Gagal mengupload dokumen {$field}.",
         ['field' => $field],
         422
      );
   }


   $file =
      $_FILES[$field];


   $extension =
      strtolower(
         pathinfo(
            $file['name'],
            PATHINFO_EXTENSION
         )
      );


   if (
      !in_array(
         $extension,
         $allowedExtensions,
         true
      )
   ) {

      responseJson(
         false,
         "Format dokumen {$field} tidak diperbolehkan.",
         ['field' => $field],
         422
      );
   }


   /**
    * Maksimal 5 MB
    */

   if ($file['size'] > 5 * 1024 * 1024) {

      responseJson(
         false,
         "Ukuran dokumen {$field} maksimal 5 MB.",
         ['field' => $field],
         422
      );
   }


   $filename =
      $prefix .
      '_' .
      bin2hex(random_bytes(8)) .
      '.' .
      $extension;


   $destination =
      $uploadDir . $filename;


   if (
      !move_uploaded_file(
         $file['tmp_name'],
         $destination
      )
   ) {

      responseJson(
         false,
         "Gagal menyimpan dokumen {$field}.",
         ['field' => $field],
         500
      );
   }


   return $filename;
}


/**
 * =========================================================
 * UPLOAD DOKUMEN
 * =========================================================
 */

$fileKtp =
   uploadDocument(
      'ktp',
      'ktp_' . $userId,
      $uploadDir,
      ['pdf']
   );


$fileKk =
   uploadDocument(
      'kk',
      'kk_' . $userId,
      $uploadDir,
      ['pdf']
   );


$fileIjazah =
   uploadDocument(
      'ijazah',
      'ijazah_' . $userId,
      $uploadDir,
      ['pdf']
   );


/**
 * file_dokumen
 *
 * Dipakai untuk dokumen tambahan/pasfoto.
 */

$fileDokumen =
   uploadDocument(
      'pasfoto',
      'dokumen_' . $userId,
      $uploadDir,
      ['jpg', 'jpeg', 'png', 'pdf']
   );


/**
 * =========================================================
 * TRANSACTION
 * =========================================================
 */

try {

   $pdo->beginTransaction();


   /**
    * =====================================================
    * UPDATE
    * =====================================================
    */

   $sql = "
        UPDATE register_pmb
        SET
            fullname = :fullname,
            gender = :gender,
            place = :place,
            datebirth = :datebirth,
            agama = :agama,
            ukuran_baju = :ukuran_baju,
            region = :region,
            address_card = :address_card,
            addrees_point = :addrees_point,
            number_id = :number_id,
            phone_number = :phone_number,
            email_register = :email_register,
            provinsi = :provinsi,
            kabupaten = :kabupaten,
            kecamatan = :kecamatan,
            kelurahan = :kelurahan,
            year_graduation = :year_graduation,
            name_mother = :name_mother,
            number_kip = :number_kip,
            jenis_pembiayaan = :jenis_pembiayaan,
            id_program = :id_program
    ";


   /**
    * Hanya update file kalau
    * user benar-benar upload file baru.
    */

   if ($fileKtp !== null) {

      $sql .= ",
            file_ktp = :file_ktp
        ";
   }


   if ($fileKk !== null) {

      $sql .= ",
            file_kk = :file_kk
        ";
   }


   if ($fileIjazah !== null) {

      $sql .= ",
            file_ijazah = :file_ijazah
        ";
   }


   if ($fileDokumen !== null) {

      $sql .= ",
            file_dokumen = :file_dokumen
        ";
   }


   /**
    * Jangan pernah menurunkan tahap.
    */

   $sql .= "
        WHERE id = :id
        LIMIT 1
    ";


   $stmt =
      $pdo->prepare($sql);


   $params = [

      'fullname' =>
      $fullname,

      'gender' =>
      $gender,

      'place' =>
      $place,

      'datebirth' =>
      $datebirth,

      'agama' =>
      $agama,

      'ukuran_baju' =>
      $ukuranBaju,


      'id_program' =>
      $id_program,

      /**
       * region menggunakan provinsi
       * karena kolom region wajib.
       */
      'region' =>
      $provinsi,

      'address_card' =>
      $address,

      'addrees_point' =>
      trim(
         $kelurahan .
            ', ' .
            $kecamatan .
            ', ' .
            $kabupaten .
            ', ' .
            $provinsi
      ),

      'number_id' =>
      $nik,

      'phone_number' =>
      $phone,

      'email_register' =>
      $email,

      'provinsi' =>
      $provinsi,

      'kabupaten' =>
      $kabupaten,

      'kecamatan' =>
      $kecamatan,

      'kelurahan' =>
      $kelurahan,

      'year_graduation' =>
      $yearGraduation,

      'name_mother' =>
      $nameMother,

      'number_kip' =>
      $numberKip !== ''
         ? $numberKip
         : null,

      'jenis_pembiayaan' =>
      $jenisPembiayaan,


      'id' =>
      $userId
   ];


   if ($fileKtp !== null) {

      $params['file_ktp'] =
         $fileKtp;
   }


   if ($fileKk !== null) {

      $params['file_kk'] =
         $fileKk;
   }


   if ($fileIjazah !== null) {

      $params['file_ijazah'] =
         $fileIjazah;
   }


   if ($fileDokumen !== null) {

      $params['file_dokumen'] =
         $fileDokumen;
   }


   $stmt->execute($params);


   /**
    * =====================================================
    * CEK KELENGKAPAN TAHAP 02
    * =====================================================
    */

   $check = $pdo->prepare("
    SELECT
        number_id,
        fullname,
        gender,
        agama,
        ukuran_baju,
        place,
        datebirth,
        region,
        address_card,
        provinsi,
        kabupaten,
        kecamatan,
        kelurahan,
        name_mother,
        jenis_pembiayaan,
        year_graduation,
        file_ktp,
        file_kk,
        file_ijazah,
        file_dokumen,
        id_program
    FROM register_pmb
    WHERE id = :id
    LIMIT 1
");

   $check->execute([
      'id' => $userId
   ]);

   $updatedUser = $check->fetch(PDO::FETCH_ASSOC);


   if (!$updatedUser) {

      throw new PDOException(
         'Data peserta tidak ditemukan setelah update.'
      );
   }


   /**
    * =====================================================
    * REQUIRED TAHAP 02
    * =====================================================
    */

   $requiredFields = [

      'number_id',
      'fullname',
      'gender',
      'agama',
      'ukuran_baju',
      'place',
      'datebirth',
      'region',
      'address_card',
      'provinsi',
      'kabupaten',
      'kecamatan',
      'kelurahan',
      'name_mother',
      'year_graduation',
      'file_ktp',
      'file_kk',
      'file_ijazah',
      'file_dokumen',
      'id_program'

   ];


   $isComplete = true;

   $missingFields = [];


   foreach ($requiredFields as $field) {

      if (
         !isset($updatedUser[$field]) ||
         trim((string) $updatedUser[$field]) === ''
      ) {

         $isComplete = false;

         $missingFields[] = $field;
      }
   }

   /**
    * =====================================================
    * UPDATE TAHAP
    * =====================================================
    *
    * Jika lengkap:
    *
    * Tahap 02 selesai
    * Tahap aktif menjadi 03
    *
    * Jika belum lengkap:
    * tetap di tahap sebelumnya.
    *
    */

   if ($isComplete) {

      $stageStmt = $pdo->prepare("UPDATE register_pmb
    SET
        tahap_aktif = 2,
        status_pendaftaran = 'DATA_DOKUMEN'
    WHERE id = :id
");

      $stageStmt->execute([
         'id' => (int) $_SESSION['pmb_user_id']
      ]);

      $stageStmt->execute([
         'id' => $userId
      ]);

      $nextStage = max(
         3,
         (int) $user['tahap_aktif']
      );
   } else {

      $nextStage =
         (int) $user['tahap_aktif'];
   }

   $pdo->commit();


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJson(
      true,
      $isComplete
         ? 'Data dan dokumen berhasil disimpan. Tahap berikutnya telah dibuka.'
         : 'Data dan dokumen berhasil disimpan.',
      [
         'id' =>
         $userId,

         'complete' =>
         $isComplete,

         'tahap_aktif' =>
         $nextStage,

         'redirect' =>
         $isComplete
            ? './pmb/register-card'
            : null
      ],
      200
   );
} catch (PDOException $e) {

   if (
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   responseJson(
      false,
      'Gagal menyimpan data. ' . $e->getMessage(),
      [],
      500
   );
}
