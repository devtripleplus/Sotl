@extends('admin.general')
@section('contentsection')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users Tables
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a  class="active" href="/admin/users">User Management</a></li>
        
      </ol>
    </section>
   
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data->toArray() as $user)
                  <tr>
                    <td>{{$user['id']}}</td>
                    <td>{{$user['name']}}</td>
                    <td>{{$user['email']}}</td>
                    <td> {{$user['role']}}</td>
                    <td><a href="/admin/user/edit/{{$user['id']}}">Edit</a> &nbsp;&nbsp;&nbsp;<a class="deleteUser" href="/admin/user/delete/{{$user['id']}}">X</a></td>

                  </tr>
                  @endforeach
                
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<script type="text/javascript">
  jQuery(document).ready( function(){
        jQuery(".deleteUser").click( function(){
          var result = confirm("Want to delete this user?");
          if (result) {
            window.location.href = jQuery(this).attr('href');
          }
          else{
          jQuery(this).attr('href','');
          }
        });

  });

</script>

    <!-- /.content -->
  @endsection('contentsection')

