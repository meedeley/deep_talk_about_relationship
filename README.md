# Ngulik Laravel

1. With - Digunakan untuk eager loading relasi sebelum query dijalankan, cocok jika relasi sudah pasti diperlukan sejak awal untuk mencegah N+1 query dan meningkatkan efisiensi.
2. Load - Digunakan untuk eager loading relasi setelah query dijalankan, berguna jika kebutuhan meload relasi baru diputuskan setelah data utama diambil.
3. Pluck - Mengambil semua nilai dari satu kolom dalam tabel.
4. Find - Mencari Id Table
5. Cookie - Data Simpan Disisi Client
6. Session - Data Disimpan Disisi Server
7. toJson - Mengubah data menjadi format JSON string.
8. toArray - Mengubah data menjadi format array PHP.
9. json_encode - Mengubah data PHP (array atau objek) menjadi string JSON.
10. json_decode -  Mengubah string JSON menjadi data PHP (array atau objek). 

    -- Mempelajari Relasi One To One

    <!-- Migrations Seller -->
    ```
    Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    ```

    <!-- Migrations Cities -->
    ```
      Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->unique()->constrained();
            $table->string('name');
            $table->timestamps();
        });
    ```

    <!-- Relasi Model Seller -->
    ```
    Class Seller extends Model {
        ...
        public function city(): HasOne
        {
            return $this->hasOne(City::class, 'seller_id', 'id');
        }
    }
    ```

    <!-- Relasi Model City -->
    ```
    Class City extends Models {
        ...
        public function seller(): BelongsTo
        {
            return $this->belongsTo(Seller::class, 'seller_id', 'id');
        }
    } 
    ```
    -- Mempelajari Relasi One To Many
    -- Mempelajari Relasi Many To Many
        --
