


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Menu</title>
        {{-- <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.1.3/css/bootstrap.min.css" integrity="sha384-Jt6Tol1A2P9JBesGeCxNrxkmRFSjWCBW1Af7CSQSKsfMVQCqnUVWhZzG0puJMCK6" crossorigin="anonymous"> --}}

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
        <link rel="stylesheet" href="{{ asset('bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>


        <div class="container" style="padding-top:50px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header"><h5 class="float-left">Menu</h5>
                        </div>
                        <div class="card-body">
                            <ul id="myEditor" class="sortableLists list-group">
                            </ul>
                            <div  style="margin-top:20px;">
                              <button id="btnOutput" type="button" style="float:right" class="btn btn-success"><i class="fas fa-check-square"></i> Save Changes</button>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-6" >
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">Add Or Edit Item</div>
                        <div class="card-body">
                            <form id="frmEdit" method="post" action=" " class="form-horizontal">
                              @csrf
                                <div class="form-group">
                                    <label for="text">Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Text">
                                        <div class="input-group-append">
                                            <button type="button" id="myEditor_icon" class="btn btn-outline-secondary"></button>
                                        </div>
                                        <input type="hidden" name="icon" value="empty" class="item-menu" id="icon_menu">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text">Name Ar</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control item-menu" name="name_en" id="name_en" placeholder="Text">
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control item-menu" name="id" id="menu_id" placeholder="Text">
                                {{-- <div class="form-group">
                                    <label for="text"> description</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control item-menu" name="disc" id="disc" placeholder="Text">
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="text">Technical Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control item-menu" name="technical_name" id="technical_name" placeholder="Text">
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Edit</button>
                            {{-- <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
        {{-- <script src="https://cdn.rtlcss.com/bootstrap/v4.1.3/js/bootstrap.min.js" integrity="sha384-C/pvytx0t5v9BEbkMlBAGSPnI1TQU1IrTJ6DJbC8GBHqdMnChcb6U4xg4uRkIQCV" crossorigin="anonymous"></script> --}}
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="{{asset('jquery-menu-editor.js')}} "></script>
        <script type="text/javascript" src="{{ asset('bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('bootstrap-iconpicker/js/bootstrap-iconpicker.min.js')}}"></script>
        <script>
            jQuery(document).ready(function () {
                $( "#myEditor" ).load( "{{ url('all_menus_list') }}", function(data) {
                  editor.setData(data);
                });
                // icon picker options
                var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
                // sortable list options
                var sortableListOptions = {
                    placeholderCss: {'background-color': "#cccccc"}
                };

                var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
                editor.setForm($('#frmEdit'));
                editor.setUpdateButton($('#btnUpdate'));
                $('#btnReload').on('click', function () {
                    editor.setData(arrayjson);
                });
                $('#btnUpdate').click(function(){
                    var url = "{{ Route('editMenu') }}";
                    // alert($('#menu_id').val());
                          // Start Ajax
                            $.ajaxSetup({
                              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                            });
                            $.ajax({
                              url: url,
                              dataType: 'json',
                              data: {
                                name:$('#text').val(),
                                icon:$('#icon_menu').val(),
                                name_ar:$('#name_ar').val(),
                                disc:$('#disc').val(),
                                technical_name:$('#technical_name').val(),
                                menu_id:$('#menu_id').val(),
                              },
                              type: 'POST',

                              beforeSend:function(){

                              },
                              success:function(msg){
                                if (msg.data == 'successEdit') {
                                  $( "#myEditor" ).load( "{{ url('all_menus_list') }}", function(data) {
                                    editor.setData(data);
                                  });
                                }
                              }
                            });
                return false;

                });
                // $('#btnAdd').click(function(){
                //     var url = "{{ Route('addNewMenu') }}";
                //           // Start Ajax
                //             $.ajaxSetup({
                //               headers: {
                //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //               }
                //             });
                //             $.ajax({
                //               url: url,
                //               dataType: 'json',
                //               data: {
                //                 name:$('#text').val(),
                //                 icon:$('#icon_menu').val(),
                //                 name_ar:$('#name_ar').val(),
                //                 disc:$('#disc').val(),
                //                 technical_name:$('#technical_name').val(),
                //               },
                //               type: 'POST',
                //
                //               beforeSend:function(){
                //
                //               },
                //               success:function(msg){
                //                 if (msg.data == 'successAdd') {
                //                   $( "#myEditor" ).load( "{{ url('all_menus_list') }}", function(data) {
                //                     editor.setData(data);
                //                   });
                //                 }
                //               }
                //             });
                // return false;
                //
                // });
                // $(document).on('click', '.btnRemove', function (e) {
                //   e.preventDefault();
                //   $('#text').val('');
                //   $('#icon_menu').val('');
                //   $('#name_ar').val('');
                //   $('#disc').val('');
                //   $('#technical_name').val('');
                //   var url = "{{ Route('deleteMenu') }}";
                //           // Start Ajax
                //           $.ajaxSetup({
                //             headers: {
                //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //             }
                //           });
                //
                //           $.ajax({
                //             url: url,
                //             dataType: 'json',
                //             data: {
                //               menu_id:$('#menu_id').val(),
                //             },
                //             type: 'POST',
                //
                //             beforeSend:function(){
                //             },
                //             success:function(msg){
                //               if (msg.data == 'successDelete') {
                //                 $('#menu_id').val('');
                //                 $( "#myEditor" ).load( "{{ url('all_menus_list') }}", function(data) {
                //                   editor.setData(data);
                //                 });
                //               }
                //             }
                //
                //           });
                //
                //
                //
                //
                //
                // });
                /* ====================================== */

                  $("#btnOutput").click(function(){
                    var data = editor.getString() ;
                    $("#out").text(data);
                    var url = "{{ Route('editAllMenus') }}";
                            // Start Ajax
                            $.ajaxSetup({
                              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                            });

                            $.ajax({
                              url: url,
                              dataType: 'json',
                              data: {
                                menu:data,
                              },
                              type: 'POST',

                              beforeSend:function(){

                              },
                              success:function(msg){
                                if (msg.data == 'successAllEdit') {
                                  $( "#myEditor" ).load( "{{ url('all_menus_list') }}", function(data) {
                                    editor.setData(data);
                                  });
                                }
                              }
                            });



                return false;


                  });





                /** PAGE ELEMENTS **/
                $('[data-toggle="tooltip"]').tooltip();
                $.getJSON( "https://api.github.com/repos/davicotico/jQuery-Menu-Editor", function( data ) {
                    $('#btnStars').html(data.stargazers_count);
                    $('#btnForks').html(data.forks_count);
                });
            });
        </script>


        <script>
        // $('#btnOutput').on('click', '#hitSearch', function() {
        //   alert();
        //   var form = $('#searchInstall').serialize();
        //   $.ajax({
        // url:" ",
        // method: 'GET',
        // data:form,
        // dataType:'json',
        // success:function(data)
        // {
        // $('#installents').html(data.table_data);
        // }
        // });
        //     return false;
        //
        // });
        //
        // ============================================

        </script>
    </body>
</html>
