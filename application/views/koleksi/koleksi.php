<div class="row">
	<div class="col-lg-6">

		<h2>Data Koleksi</h2>
	</div>
	<div class="col-lg-6 text-right">
		<a href="<?php echo base_url().'koleksi/tambah'; ?>" class="btn btn-primary" style="margin-top:17px">Tambah Data</a>
	</div>
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No. Inventaris</th>
						<th>Nama Koleksi</th>
						<th>Foto</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($koleksi as $data){ ?>
					<tr>
						<td>
							<?php echo $data['no_inventaris']; ?>
						</td>
						<td>
							<?php echo $data['nama_koleksi']; ?>
						</td>
						<td>
							<?php
                                if(!empty($data['foto'])){
									$foto = base64_encode(file_get_contents($data['foto']));
                                	echo '<img src="data:image/jpeg;base64,'.$foto.'">';
								}else{
									echo '-';
								}
                            ?>
						</td>
						<td>
							<a href="<?php echo base_url('koleksi/lihat/'.$data["no_inventaris"].'');?>">Lihat</a>
							<a href="<?php echo base_url('koleksi/ubah/'.$data["no_inventaris"].'');?>">Ubah</a>
							<a href="<?php echo base_url('koleksi/hapus/'.$data["no_inventaris"].'');?>">Hapus</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
