<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong>Jadwal Dosen</strong> Menu </h1>
<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Jadwal Dosen List 
                    <?php if($user['teacher_id']) { ?>
                        <button class="btn btn-primary btn-sm float-end btnAdd" data-bs-toggle="modal" data-bs-target="#formModal">Create New</button>
                    <?php } ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Dosen</th>
                                <th>Tanggal & Waktu</th>
                                <th>Tempat</th>
                                <th>Keterangan</th>

                                <th>Pergantian</th>

                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item) : ?>
                                <tr <?= $item['change_description'] ? 'style="background-color: #fff6d1;"' : '' ?> >
                                    <td><?= $item['id'] ?> </td>
                                    <td><?= $item['teacher_name'] ?> </td>
                                    <td><?= date('d F Y', strtotime($item['date'] . ' ' . $item['time'])); ?> </td>
                                    <td><?= $item['place'] ?> </td>
                                    <td><?= $item['description'] ?> </td>

                                    <td>
                                        <?php if($item['change_description']) { ?>
                                        <b>Tanggal & Waktu:</b>
                                        <p><?= date('d F Y', strtotime($item['change_date'] . ' ' . $item['change_time'])); ?></p>
                                        <b>Keterangan:</b>
                                        <p><?= $item['change_description'] ?? '-' ?></p>
                                        <?php } else { echo '-'; } ?>
                                    </td>

                                    <td><?= date('d F Y', strtotime($item['created_at'])); ?></td>
                                    <td><?= date('d F Y', strtotime($item['updated_at'])); ?></td>
                                    <td>
                                        <?php if($user['teacher_id']) { ?>
                                            <button class="btn btn-info btn-sm btnEdit" data-bs-toggle="modal" data-bs-target="#formModalCustom" 
                                                data-id="<?= $item['id']; ?>" 
                                                data-teacher_name="<?= $item['teacher_name']; ?>"
                                                data-date="<?= $item['date']; ?>"
                                                data-time="<?= $item['time']; ?>"
                                                data-place="<?= $item['place']; ?>"
                                                data-description="<?= $item['description']; ?>"

                                                data-change_date="<?= $item['change_date']; ?>"
                                                data-change_time="<?= $item['change_time']; ?>"
                                                data-change_description="<?= $item['change_description']; ?>"
                                            >Pergantian Jadwal</button>
                                        
                                            <form action="<?= base_url('schedulles/delete/' . $item['id']); ?>" method="post" class="d-inline">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure delete?')">Delete</button>
                                            </form>
                                        <?php } ?>
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
            <form action="<?= base_url('schedulles/create'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="teacher_id" id="teacher_id" value="<?= $user['teacher_id'] ?>">
                    <div class="mb-3">
                        <label for="teacher_name" class="col-form-label">Dosen:</label>
                        <input type="text" class="form-control" name="teacher_name" disabled id="teacher_name" value="<?= $user['teacher_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="col-form-label">Tanggal:</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="col-form-label">Waktu:</label>
                        <input type="time" class="form-control" name="time" id="time" required>
                    </div>
                    <div class="mb-3">
                        <label for="place" class="col-form-label">Tempat:</label>
                        <input type="text" class="form-control" name="place" id="place" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="col-form-label">Keterangan:</label>
                        <textarea name="description" id="description" class="form-control" cols="3" rows="1"></textarea>
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

<div class="modal fade" id="formModalCustom" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="formModalLabel">Pergantian Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('schedulles/create'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="teacher_id" id="teacher_id" value="<?= $user['teacher_id'] ?>">
                    <div class="mb-3">
                        <label for="teacher_name" class="col-form-label">Dosen:</label>
                        <input type="text" class="form-control" name="teacher_name" disabled id="teacher_name2" value="<?= $user['teacher_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="change_date" class="col-form-label">Tanggal:</label>
                        <input type="date" class="form-control" name="change_date" id="change_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="change_time" class="col-form-label">Waktu:</label>
                        <input type="time" class="form-control" name="change_time" id="change_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="change_place" class="col-form-label">Tempat:</label>
                        <input type="text" class="form-control" name="change_place" id="change_place" required>
                    </div>
                    <div class="mb-3">
                        <label for="change_description" class="col-form-label">Keterangan:</label>
                        <textarea name="change_description" id="change_description" class="form-control" cols="3" rows="1"></textarea>
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
            'teacher_name',
            'date',
            'time',
            'place',
            'description',
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

            $(`#teacher_name`).val(`<?= $user['teacher_name'] ?>`);
            
        });
        $(".btnEdit").click(function() {
            
            $('#modalTitle').html('form Edit Data');
            $('.modal-footer button[type=submit]').html('Perbarui Jadwal');
            $('.modal-content form').attr('action', '<?= base_url('schedulles/update') ?>');

            fields = [
                'id',
                'teacher_id',
                'teacher_name',
                'custom_date',
                'custom_time',
                'custom_place',
                'custom_description',
            ];
                
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