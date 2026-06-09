<?php

include 'php/koneksi.php';

if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $keyword = $_GET['keyword'];
    
    $query = "SELECT * FROM produk WHERE 
              nama_produk LIKE '%$keyword%' OR 
              brand LIKE '%$keyword%'";
} else {
    $query = "SELECT * FROM produk";
}

$data = mysqli_query($koneksi, $query);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kecantikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  </head>
  <body>
    <div class="dashboard-container">
        <!--nama brand (header)-->
        <div class="header mb-4">
            <h2 class="fw-semibold">FNK Beauty</h2>
        </div>

        <!--Tabs-->
        <div class="all-tabs d-flex justify-content-between mb-3">
            <div class="tab-section1">
                <!--Button tambah barang-->
                <div class="add-stock-tab">
                    <button class="btn shadow-sm bg-body-tertiary rounded" type="button" style="background-color: white;" onclick="bukaModal()">+ Tambah Stok</button>
                </div>
                <!--Tabs tambahan-->
                <div class="tabs">
                    <span style="color: #604d53;">All stock</span>
                    <span>Tersedia</span>
                    <span>Hampir Habis</span>
                    <span>Kosong</span>
                </div>
            </div>
            <div class="tab-section2">
                <!--Tab pencari-->
                <div class="search-tab">
                    <div class="container-fluid">
                        <form class="d-flex" role="search" style="gap: 10px;" action="index.php" method="GET">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="keyword"/>
                            <button class="btn" type="submit" style="border-color: #604d53; color: #604d53;">Cari</button>
                            <a href="index.php" class="btn" style="border-color: #604d53; color: #604d53; text-decoration: none; padding: 6px 12px; border: 1px solid #000000; border-radius: 4px;">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Tabel-->
        <div class="tabel">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Kategori</th>
                        <th>Jumlah Stok</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="tbody" id="tbody">
                        <?php
                        $no = 1;

                        while($row = mysqli_fetch_assoc($data)){    
                        ?>

                        <tr id="row-<?= $row['id']; ?>">

                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_produk']; ?></td>
                            <td><?= $row['brand']; ?></td>
                            <td><?= $row['kategori']; ?></td>
                            <td><?= $row['stok']; ?></td>
                            <td><?= $row['harga']; ?></td>

                            <td>
                                <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: white;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="bukaUpdate(
                                            '<?= $row['id']; ?>', 
                                            '<?= $row['nama_produk']; ?>', 
                                            '<?= $row['brand']; ?>', 
                                            '<?= $row['kategori']; ?>', 
                                            '<?= $row['stok']; ?>', 
                                            '<?= $row['harga']; ?>'
                                        ); return false;">Update</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" style="color: red;" onclick="hapus('row-<?= $row['id']; ?>');">Delete</a></li>
                                </ul>
                            </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--Modal-->
        <div class="overlay" id="overlay">
                <div class="modal-box">
                    <form action="php/proses.php" method="POST">

                    <p class="modal-box-title">Tambah Stok</p> <!--Judul form-->

                    <div class="modal-box-data">
                        <label>Nama Produk</label>
                        <input type="text" id="f-nama" name="nama_produk" placeholder="Contoh: Glow Serum Vit C">
                    </div>
                    <div class="modal-box-data">
                        <label>Brand</label>
                        <input type="text" id="f-brand" name="brand" placeholder="Contoh: Wardah">
                    </div>
                    <div class="modal-box-data">
                        <label>Kategori</label>
                        <select id="f-kategori" name="kategori">
                            <option value="">— Pilih kategori —</option>
                            <option>Sunscreen</option>
                            <option>Serum</option>
                            <option>Moisturizer</option>
                            <option>Toner</option>
                            <option>Cleanser</option>
                            <option>Mask</option>
                            <option>Eye Cream</option>
                            <option>Lip Care</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="modal-box-row"> 
                        <div class="modal-box-data">
                             <label>Jumlah Stok</label>
                             <input type="number" id="f-stok" name="stok" placeholder="0" min="0">
                        </div>
                        <div class="modal-box-data">
                             <label>Harga (Rp)</label>
                             <input type="number" id="f-harga" name="harga" placeholder="0" min="0">
                        </div>
                    </div>

                    <div class="modal-box-action">
                        <button class="btn-batal" type="button" onclick="tutupModal()">Batal</button>
                        <button class="btn-simpan" type="submit" id="btn-simpan" onclick="simpan()">Simpan</button>
                    </div>
                </div>
                </form>
        </div>

        <div class="overlay" id="overlay-update" style="display: none;"> 
            <div class="modal-box">
                <form action="php/proses_update.php" method="POST">
            
                    <input type="hidden" id="u-id" name="id">

                    <p class="modal-box-title">Update Stok</p>

                    <div class="modal-box-data">
                        <label>Nama Produk</label>
                        <input type="text" id="u-nama" name="nama_produk">
                    </div>
                
                    <div class="modal-box-data">
                        <label>Brand</label>
                        <input type="text" id="u-brand" name="brand">
                    </div>

                    <div class="modal-box-data">
                        <label>Kategori</label>
                        <select id="u-kategori" name="kategori">
                        <option value="Sunscreen">Sunscreen</option>
                        <option value="Serum">Serum</option>
                        <option value="Moisturizer">Moisturize</option>
                        <option value="Toner">Toner</option>
                        <option value="Cleanser">Cleanser</option>
                        <option value="Mask">Mask</option>
                        <option value="Eye Cream">Eye Cream</option>
                        <option value="Lip Care">Lip Care</option>
                        <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="modal-box-data">
                        <label>Jumlah Stok</label>
                        <input type="number" id="u-stok" name="stok">
                    </div>

                    <div class="modal-box-data">
                        <label>Harga (Rp)</label>
                        <input type="number" id="u-harga" name="harga">
                    </div>

                    <div class="model-box-action">
                        <button class="btn-batal" type="button" onclick="tutupUpdate()">Batal</button>
                        <button class="btn-simpan" type="submit" id="btn-simpan" name="update" onclick="simpan()">Update Data</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        let editRowId = null;
        let rowCounter = 2;

        function bukaModal(){
            editRowId = null;
            document.querySelector('.modal-box-title').textContent = 'Tambah Stok';
            document.getElementById('btn-simpan').textContent = 'Simpan';
            ['f-nama', 'f-brand', 'f-stok', 'f-harga'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('f-kategori').value = '';
            document.getElementById('overlay').classList.add('show');
        }

        function bukaUpdate(rowId){
            const row = document.getElementById(rowId);
            const cells = row.querySelectorAll('td');

            editRowId = rowId;
            document.querySelector('.modal-box-title').textContent = 'Update Stok';
            document.getElementById('btn-simpan').textContent = 'Update';

            document.getElementById('f-nama').value = cells[1].textContent;
            document.getElementById('f-brand').value = cells[2].textContent;
            document.getElementById('f-kategori').value = cells[3].textContent;
            document.getElementById('f-stok').value = cells[4].textContent;
            document.getElementById('f-harga').value = cells[5].textContent.replace('Rp', '').replace(/\./g, '');
            document.getElementById('overlay').classList.add('show');
        }

        function tutupModal(){
            document.getElementById('overlay').classList.remove('show');
            editRowId = null;
        }

        function simpan(){
            const nama = document.getElementById('f-nama').value.trim();
            const brand = document.getElementById('f-brand').value.trim();
            const kategori = document.getElementById('f-kategori').value;
            const stok = document.getElementById('f-stok').value;
            const harga = document.getElementById('f-harga').value;

            if (!nama || !brand || !kategori || !stok || !harga){
                alert('Semua field wajib diisi!');
                return;
            }

            const hargarp = 'Rp' + Number(harga).toLocaleString('id-ID');

            if(editRowId !== null){
                const row = document.getElementById(editRowId);
                const cells = row.querySelectorAll('td');
                cells[1].textContent = nama;
                cells[2].textContent = brand;
                cells[3].textContent = kategori;
                cells[4].textContent = stok;
                cells[5].textContent = hargarp;
            } else {
                rowCounter++;
                const newId = 'row-' + rowCounter;
                const tbody = document.getElementById('tbody');
                const nobaris = tbody.querySelectorAll('tr').length + 1;

                const tr = document.createElement('tr');
                tr.id = newId;
                tr.innerHTML = `
                    <td>${nobaris}</td>
                    <td>${nama}</td>
                    <td>${brand}</td>
                    <td>${kategori}</td>
                    <td>${stok}</td>
                    <td>${hargarp}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: white;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="bukaUpdate('${newId}'); return false">Update</a></li>
                                <li><a class="dropdown-item" href="#" style="color: red;" onclick="hapus('${newId}'); return false">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            }
            tutupModal();
        }

        function hapus(rowId){
            if(confirm('Yakin ingin dihapus?')){
                const idAsli = rowId.replace('row-', '');
                
                window.location.href = "php/proses_delete.php?id=" + idAsli;
            }
        }

        function bukaUpdate(id, nama, brand, kategori, stok, harga) {
            document.getElementById('u-id').value = id;
            document.getElementById('u-nama').value = nama;
            document.getElementById('u-brand').value = brand;
            document.getElementById('u-kategori').value = kategori;
            document.getElementById('u-stok').value = stok;
            document.getElementById('u-harga').value = harga;

            document.getElementById('overlay-update').style.display = 'flex';
        }

        function tutupUpdate() {
            document.getElementById('overlay-update').style.display = 'none';
        }
    </script>
  </body>
</html>