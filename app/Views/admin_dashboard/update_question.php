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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add question</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url("admin/dashboard/questions/update/")?>" method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="qId" value="<?php echo $id ?>"> 
                        <div class="card-body">
                            <div class="form-group">
                                <label for="questionText">Question text</label>
                                <input type="text" class="form-control" name="questionText" id="questionText" placeholder="Question text?" value="<?php echo $question[0]->question_text ?>">
                            </div>
                            <div class="form-group">
                                <label for="questionAnswer">Answer</label>
                                <input type="text" class="form-control" name="questionAnswer" id="questionAnswer" placeholder="Answer." value="<?php echo $question[0]->answer ?>">
                            </div>
                            <div class="form-group">
                                    <label for="questionText">Category</label>
                                    <select class="form-control" id="categoryId" name="categoryId">
                                        <?php foreach($categories as $cat) { ?>
                                            <option value="<?php echo $cat->id ?>" <?php if($cat->id == $question[0]->category_id) { echo "selected" ;} ?>><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                            </div>

                            <div class="form-group">
                                <label for="mediaInputFile">Media attachement</label>
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="mediaInputFile" id="mediaInputFile">
                                    <label class="custom-file-label" for="mediaInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>