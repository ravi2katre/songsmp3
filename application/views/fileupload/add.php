
<div class="card">
    <div class="card-header title_bar">
        <h2> <?php echo $page_title; ?></h2>
    </div>
    <div class="card-block">


<!-- Bootstrap styles -->
    <!--link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"-->
    <!-- Generic page styles -->
    <!--link rel="stylesheet" href="<?php //echo base_url('assets/jQuery-File-Upload/css/style.css') ?> " -->
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo base_url('assets/jQuery-File-Upload/css/jquery.fileupload.css'); ?> ">
    <link rel="stylesheet" href="<?php echo base_url('assets/jQuery-File-Upload/css/jquery.fileupload-ui.css'); ?> ">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('assets/jQuery-File-Upload/css/jquery.fileupload-noscript.css'); ?>"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('assets/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css'); ?>"></noscript>
    <style>
        /* Hide Angular JS elements before initializing */
        .ng-cloak {
            display: none;
        }
    </style>





    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload"  action="fileupload/" method="POST" enctype="multipart/form-data" data-ng-app="demo" data-ng-controller="DemoFileUploadController"  data-file-upload="options" data-ng-class="{'fileupload-processing': processing() || loadingFiles}">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript>
            <input type="hidden" name="redirect" value="fileupload">

        </noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple ng-disabled="disabled">
                </span>
                <button type="button" class="btn btn-primary start" data-ng-click="submit()">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="button" class="btn btn-warning cancel" data-ng-click="cancel()">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fade" data-ng-class="{in: active()}">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" data-file-upload-progress="progress()"><div class="progress-bar progress-bar-success" data-ng-style="{width: num + '%'}"></div></div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped files ng-cloak">
            <tr data-ng-repeat="file in queue" data-ng-class="{'processing': file.$processing()}">

                <!-- ... -->
                <td><input type="text"  name="title" ng-model="file.title" placeholder="Title"></td>
                <!-- ... -->
                <td data-ng-switch data-on="!!file.thumbnailUrl">
                    <div class="preview" data-ng-switch-when="true">
                        <a data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}" data-gallery><img data-ng-src="{{file.thumbnailUrl}}" alt=""></a>
                    </div>
                    <div class="preview" data-ng-switch-default data-file-upload-preview="file"></div>
                </td>
                <td>
                    <p class="name" data-ng-switch data-on="!!file.url">
                        <span data-ng-switch-when="true" data-ng-switch data-on="!!file.thumbnailUrl">
                            <a data-ng-switch-when="true" data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}" data-gallery>{{file.name}}</a>
                            <a data-ng-switch-default data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}">{{file.name}}</a>
                        </span>
                        <span data-ng-switch-default>{{file.name}}</span>
                    </p>
                    <strong data-ng-show="file.error" class="error text-danger">{{file.error}}</strong>
                </td>
                <td>
                    <p class="size">{{file.size | formatFileSize}}</p>
                    <div class="progress progress-striped active fade" data-ng-class="{pending: 'in'}[file.$state()]" data-file-upload-progress="file.$progress()"><div class="progress-bar progress-bar-success" data-ng-style="{width: num + '%'}"></div></div>
                </td>
                <td>
                    <button type="button" class="btn btn-primary start" data-ng-click="file.$submit()" data-ng-hide="!file.$submit || options.autoUpload" data-ng-disabled="file.$state() == 'pending' || file.$state() == 'rejected'">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                    <button type="button" class="btn btn-warning cancel" data-ng-click="file.$cancel()" data-ng-hide="!file.$cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                    <button data-ng-controller="FileDestroyController" type="button" class="btn btn-danger destroy" data-ng-click="file.$destroy()" data-ng-hide="!file.$destroy">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                </td>
            </tr>
        </table>
    </form>



<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/vendor/jquery.ui.widget.js'); ?>"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.iframe-transport.js'); ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload.js'); ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload-process.js'); ?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload-image.js'); ?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload-audio.js'); ?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload-video.js'); ?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload-validate.js'); ?>"></script>
<!-- The File Upload Angular JS module -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/jquery.fileupload-angular.js'); ?>"></script>
<!-- The main application script -->
<script src="<?php echo base_url('assets/jQuery-File-Upload/js/app.js'); ?>"></script>

    <script>
    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
    data.formData = {cid: '<?php echo $cid ?>',title:data.files[0].title};
    });


    </script>


    </div>
</div>