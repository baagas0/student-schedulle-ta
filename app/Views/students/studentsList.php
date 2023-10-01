<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong>Mahasiswa</strong> Menu </h1>
<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Mahasiswa List <button class="btn btn-primary btn-sm float-end btnAdd" data-bs-toggle="modal" data-bs-target="#formModal">Create New</button></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nim</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?> </td>
                                    <td><?= $item['nim'] ?> </td>
                                    <td><?= $item['name'] ?> </td>
                                    <td><?= $item['email'] ?> </td>
                                    <td><?= $item['created_at'] ?> </td>
                                    <td><?= $item['updated_at'] ?> </td>
                                    <td>
                                        <button class="btn btn-info btn-sm btnEdit" data-bs-toggle="modal" data-bs-target="#formModal" 
                                            data-id="<?= $item['id']; ?>" 
                                            data-nim="<?= $item['nim']; ?>" 
                                            data-name="<?= $item['name']; ?>" 
                                            data-email="<?= $item['email']; ?>" 
                                        >Update</button>
                                    
                                        <form action="<?= base_url('students/delete/' . $item['id']); ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure delete <?= $item['name']; ?> ?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('students/create'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="nim" class="col-form-label">Nim:</label>
                        <input type="text" class="form-control" name="nim" id="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="password" class="col-form-label">Kata Sandi:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send message</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let fields = [
            'id',
            'nim',
            'name',
            'email',
        ];

        $(".btnAdd").click(function() {
            $('#formModalLabel').html('Tambah Data');
            $('.modal-footer button[type=submit]').html('Simpan');

            for (const field of fields) {
                $(`#${field}`).val(``);
                if(field =='password') {
                    $(`#${field}`).attr('required', true);
                }
            }
            
        });
        $(".btnEdit").click(function() {
            
            $('#modalTitle').html('form Edit Data');
            $('.modal-footer button[type=submit]').html('Edit Data');
            $('.modal-content form').attr('action', '<?= base_url('students/update') ?>');

            for (const field of fields) {
                $(`#${field}`).val(
                    $(this).data(`${field}`)
                );
                if(field =='password') {
                    $(`#${field}`).attr('required', false);
                }
            }
        });

        
    });
</script>
<?= $this->endSection(); ?>