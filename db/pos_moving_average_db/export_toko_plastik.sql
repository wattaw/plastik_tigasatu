-- pos_forecasting_moving_average.failed_jobs definition
CREATE TABLE `failed_jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.kategori definition
CREATE TABLE `kategori` (
    `id_kategori` int unsigned NOT NULL AUTO_INCREMENT,
    `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_kategori`),
    UNIQUE KEY `kategori_nama_kategori_unique` (`nama_kategori`)
) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.`member` definition
CREATE TABLE `member` (
    `id_member` int unsigned NOT NULL AUTO_INCREMENT,
    `kode_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_member`),
    UNIQUE KEY `member_kode_member_unique` (`kode_member`)
) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.migrations definition
CREATE TABLE `migrations` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch` int NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 22 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.password_resets definition
CREATE TABLE `password_resets` (
    `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    KEY `password_resets_email_index` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.pembelian definition
CREATE TABLE `pembelian` (
    `id_pembelian` int unsigned NOT NULL AUTO_INCREMENT,
    `id_supplier` int NOT NULL,
    `total_item` int NOT NULL,
    `total_harga` int NOT NULL,
    `diskon` tinyint NOT NULL DEFAULT '0',
    `bayar` int NOT NULL DEFAULT '0',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_pembelian`)
) ENGINE = InnoDB AUTO_INCREMENT = 41 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.pembelian_detail definition
CREATE TABLE `pembelian_detail` (
    `id_pembelian_detail` int unsigned NOT NULL AUTO_INCREMENT,
    `id_pembelian` int NOT NULL,
    `id_produk` int NOT NULL,
    `harga_beli` int NOT NULL,
    `jumlah` int NOT NULL,
    `subtotal` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_pembelian_detail`)
) ENGINE = InnoDB AUTO_INCREMENT = 55 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.pengeluaran definition
CREATE TABLE `pengeluaran` (
    `id_pengeluaran` int unsigned NOT NULL AUTO_INCREMENT,
    `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `nominal` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_pengeluaran`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.penjualan definition
CREATE TABLE `penjualan` (
    `id_penjualan` int NOT NULL AUTO_INCREMENT,
    `id_member` int DEFAULT NULL,
    `total_item` int NOT NULL,
    `total_harga` int NOT NULL,
    `diskon` tinyint NOT NULL DEFAULT '0',
    `bayar` int NOT NULL DEFAULT '0',
    `diterima` int NOT NULL DEFAULT '0',
    `id_user` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_penjualan`)
) ENGINE = InnoDB AUTO_INCREMENT = 1747 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.penjualan_detail definition
CREATE TABLE `penjualan_detail` (
    `id_penjualan_detail` int unsigned NOT NULL AUTO_INCREMENT,
    `id_penjualan` int NOT NULL,
    `id_produk` int NOT NULL,
    `harga_jual` int NOT NULL,
    `jumlah` int NOT NULL,
    `diskon` tinyint NOT NULL DEFAULT '0',
    `subtotal` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_penjualan_detail`)
) ENGINE = InnoDB AUTO_INCREMENT = 5151 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.penjualan_detail_old definition
CREATE TABLE `penjualan_detail_old` (
    `id_penjualan_detail` int unsigned NOT NULL,
    `id_penjualan` int NOT NULL,
    `id_produk` int NOT NULL,
    `harga_jual` int NOT NULL,
    `jumlah` int NOT NULL,
    `diskon` tinyint NOT NULL DEFAULT '0',
    `subtotal` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.penjualan_old definition
CREATE TABLE `penjualan_old` (
    `id_penjualan` int unsigned NOT NULL AUTO_INCREMENT,
    `id_member` int DEFAULT NULL,
    `total_item` int NOT NULL,
    `total_harga` int NOT NULL,
    `diskon` tinyint NOT NULL DEFAULT '0',
    `bayar` int NOT NULL DEFAULT '0',
    `diterima` int NOT NULL DEFAULT '0',
    `id_user` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_penjualan`)
) ENGINE = InnoDB AUTO_INCREMENT = 98 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.personal_access_tokens definition
CREATE TABLE `personal_access_tokens` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `tokenable_id` bigint unsigned NOT NULL,
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `last_used_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
    KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.sessions definition
CREATE TABLE `sessions` (
    `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id` bigint unsigned DEFAULT NULL,
    `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.setting definition
CREATE TABLE `setting` (
    `id_setting` int unsigned NOT NULL AUTO_INCREMENT,
    `nama_perusahaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `tipe_nota` tinyint NOT NULL,
    `diskon` smallint NOT NULL DEFAULT '0',
    `path_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `path_kartu_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_setting`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.supplier definition
CREATE TABLE `supplier` (
    `id_supplier` int unsigned NOT NULL AUTO_INCREMENT,
    `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_supplier`)
) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.users definition
CREATE TABLE `users` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `level` tinyint NOT NULL DEFAULT '0',
    `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `current_team_id` bigint unsigned DEFAULT NULL,
    `profile_photo_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- pos_forecasting_moving_average.produk definition
CREATE TABLE `produk` (
    `id_produk` int unsigned NOT NULL AUTO_INCREMENT,
    `id_kategori` int unsigned NOT NULL,
    `kode_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `harga_beli` int NOT NULL,
    `diskon` tinyint NOT NULL DEFAULT '0',
    `harga_jual` int NOT NULL,
    `stok` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_produk`),
    UNIQUE KEY `produk_nama_produk_unique` (`nama_produk`),
    UNIQUE KEY `produk_kode_produk_unique` (`kode_produk`),
    KEY `produk_id_kategori_foreign` (`id_kategori`),
    CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
) ENGINE = InnoDB AUTO_INCREMENT = 52 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;