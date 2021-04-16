<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Jeopardy Game</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Jeopardy Game</li>
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
                    <h3 class="card-title">Add jeopardy game</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="<?php echo base_url("admin/dashboard/add_jeopardy_form")?>" method="post" enctype="multipart/form-data" >
                    <div class="card-body">
                        <!-- Line of Score/Categories -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Score 1</label>
                                    <select class="form-control" id="exampleFormControlSelect2" name="score1">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 1</label>
                                    <select class="form-control change_category" id="category1_1" name="category1_1">
                                        <?php foreach($categories as $cat) { ?>
                                        <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 2</label>
                                    <select class="form-control change_category" id="category2_1" name="category2_1">
                                    <?php foreach($categories as $cat) { ?>
                                        <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Score/Categories -->

                        <!-- Line of Score/Categories -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Score 2</label>
                                    <select class="form-control" id="exampleFormControlSelect2" name="score2">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 1</label>
                                    <select class="form-control change_category" id="category1_2" name="category1_2">
                                    <?php foreach($categories as $cat) { ?>
                                        <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 2</label>
                                    <select class="form-control change_category" id="category2_2" name="category2_2">
                                    <?php foreach($categories as $cat) { ?>
                                        <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Score/Categories -->

                        <!-- Line of Score/Categories -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Score 3</label>
                                    <select class="form-control" id="exampleFormControlSelect2" name="score3">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 1</label>
                                    <select class="form-control change_category" id="category1_3" name="category1_3">
                                    <?php foreach($categories as $cat) { ?>
                                        <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                    <?php } ?>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 2</label>
                                    <select class="form-control change_category" id="category2_3" name="category2_3">
                                        <?php foreach($categories as $cat) { ?>
                                            <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Score/Categories -->

                        <!-- Line of Score/Categories -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Score 4</label>
                                    <select class="form-control" id="exampleFormControlSelect2" name="score4">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 1</label>
                                    <select class="form-control change_category" id="category1_4" name="category1_4">
                                        <?php foreach($categories as $cat) { ?>
                                            <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 2</label>
                                    <select class="form-control change_category" id="category2_4" name="category2_4">
                                        <?php foreach($categories as $cat) { ?>
                                            <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Score/Categories -->

                        <!-- Line of Score/Categories -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Score 5</label>
                                    <select class="form-control" id="exampleFormControlSelect2" name="score5">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 1</label>
                                    <select class="form-control change_category" id="category1_5" name="category1_5">
                                    <?php foreach($categories as $cat) { ?>
                                        <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                    <?php } ?>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="questionText">Category 2</label>
                                    <select class="form-control change_category" id="category2_5" name="category2_5">
                                        <?php foreach($categories as $cat) { ?>
                                            <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
                                        <?php } ?>
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Score/Categories -->

                        <!-- Final Jeopardy Question -->
                            <h4> - Final Jeopardy - </h4>
                            <div class="form-group">
                                <label for="questionText">Final Jeopardy Question</label>
                                <input type="text" class="form-control" name="questionText" id="questionText" placeholder="Question text?">
                            </div>
                            <div class="form-group">
                                <label for="questionAnswer">Final Jeopardy Answer</label>
                                <input type="text" class="form-control" name="questionAnswer" id="questionAnswer" placeholder="Answer.">
                            </div>
                            <div class="form-group">
                                <label for="questionCategory">Final Jeopardy Category</label>
                                <input type="text" class="form-control" name="questionCategory" id="questionCategory" placeholder="category">
                            </div>

                            <div class="form-group">
                                    <label for="exampleFormControlSelect2">Final Jeopardy Score</label>
                                    <select class="form-control" id="exampleFormControlSelect2" name="final_jeopardy_score">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
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

                        <!-- End of Final Jeopardy Question -->

                        <!-- Double Jeopardy rounds -->

                        <!-- Line of Line of Double Jeopardy round 1 -->
                        <h4> - Double Jeopardy Round 1 - </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="questionText">Category</label>
                                    <select class="form-control" id="category_double_r1" name="category_double_r1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="questionText">Question</label>
                                    <select class="form-control" id="category_question_double_r1" name="category_question_double_r1">
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Double Jeopardy round 1 -->

                        <!-- Line of Line of Double Jeopardy round 2 -->
                        <h4> - Double Jeopardy Round 2 - </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="questionText">Category</label>
                                    <select class="form-control" id="category_double_r2" name="category_double_r2">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>      
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="questionText">Question</label>
                                    <select class="form-control" id="category_question_double_r2" name="category_question_double_r2">
                                    </select>      
                                </div>
                            </div>
                        </div>
                        <!-- End of Line of Double Jeopardy round 2 -->

                        <!-- Double Jeopardy rounds -->


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