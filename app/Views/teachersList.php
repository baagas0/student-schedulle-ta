<?= $this->extend('layouts/main'); ?>
		<?= $this->section('content'); ?>
		<h1 class="h3 mb-3"><strong><?= $title; ?></strong> List Menu </h1>
		<div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">	Dosen List <a href="<?= base_url('Teachers/form'); ?>" class="btn btn-primary btn-sm float-end" >Create New Dosen</a></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>       
									  <button type="submit" class="btn btn-outline-info btn-sm">Update</button>
									  <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
								</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
		<?= $this->endSection(); ?>
		