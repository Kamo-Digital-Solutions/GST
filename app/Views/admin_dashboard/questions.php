<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Questions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Questions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="games_table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Game Data id</th>
                            <th>Question Text</th>
                            <th>Media attachement</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($questions as $q) { ?>
                            <tr>
                                <td><?php echo $q->id ?></td>
                                <td></td>
                                <td><?php echo $q->question_text ?></td>
                                <td><?php echo $q->media_attachement ?></td>
                                <td><?php echo $q->answer ?></td>
                                <td><a href="/admin/dashboard/questions/delete/<?php echo $q->id; ?>"><i class="fas fa-trash-alt"></i> </a> <a href="/admin/dashboard/update_question/<?php echo $q->id; ?>"> <i class="fas fa-edit"></i> </a> </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
