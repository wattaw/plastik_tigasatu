INSERT INTO toko_plastik.migrations (migration,batch) VALUES
	 ('2014_10_12_000000_create_users_table',1),
	 ('2014_10_12_100000_create_password_resets_table',1),
	 ('2014_10_12_200000_add_two_factor_columns_to_users_table',1),
	 ('2019_08_19_000000_create_failed_jobs_table',1),
	 ('2019_12_14_000001_create_personal_access_tokens_table',1),
	 ('2021_03_05_194740_tambah_kolom_baru_to_users_table',1),
	 ('2021_03_05_195441_buat_kategori_table',1),
	 ('2021_03_05_195949_buat_produk_table',1),
	 ('2021_03_05_200515_buat_member_table',1),
	 ('2021_03_05_200706_buat_supplier_table',1);
INSERT INTO toko_plastik.migrations (migration,batch) VALUES
	 ('2021_03_05_200841_buat_pembelian_table',1),
	 ('2021_03_05_200845_buat_pembelian_detail_table',1),
	 ('2021_03_05_200853_buat_penjualan_table',1),
	 ('2021_03_05_200858_buat_penjualan_detail_table',1),
	 ('2021_03_05_200904_buat_setting_table',1),
	 ('2021_03_05_201756_buat_pengeluaran_table',1),
	 ('2021_03_11_225128_create_sessions_table',1),
	 ('2021_03_24_115009_tambah_foreign_key_to_produk_table',1),
	 ('2021_03_24_131829_tambah_kode_produk_to_produk_table',1),
	 ('2021_05_08_220315_tambah_diskon_to_setting_table',1);
INSERT INTO toko_plastik.migrations (migration,batch) VALUES
	 ('2021_05_09_124745_edit_id_member_to_penjualan_table',1);
