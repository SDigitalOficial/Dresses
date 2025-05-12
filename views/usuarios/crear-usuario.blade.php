@extends ('LayoutDresses.layout')

@section('ContenidoSite-01')

<div class="row">
 <div class="col-md-12 col-xl-10 offset-xl-1">
  
  <div class="content-header">
   <ul class="nav-horizontal text-center">
    <a class="btn btn-primary waves-effect waves-light" href="/dafer/usuarios"><i class="fas fa-users"></i> Users</a>
 
   </ul>
  </div>

  <div class="card m-b-30">
   <div class="card-body">
    
    <h4 class="mt-0 header-title mb-4">Create User</h4>

                                        
     {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dresses/crear-usuario'))) }}

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-text-input">Name</label>
        <div class="col-md-12">
         {{Form::text('name', '', array('class' => 'form-control','placeholder'=>'Enter Name'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Last Name</label>
        <div class="col-md-12">
         {{Form::text('last_name', '', array('class' => 'form-control','placeholder'=>'Enter Last Name'))}}
        </div>
      </div>
    
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Email</label>
        <div class="col-md-12">
         {{Form::text('email', '', array('class' => 'form-control','placeholder'=>'Enter email'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Address</label>
        <div class="col-md-12">
         {{Form::text('address', '', array('class' => 'form-control','placeholder'=>'Enter Address'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Phone</label>
        <div class="col-md-12">
         {{Form::text('phone', '', array('class' => 'form-control','placeholder'=>'Enter Phone'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Password</label>
        <div class="col-md-12">
         {{Form::password('password', array('class' => 'form-control','placeholder'=>'Enter Password'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Confirm Password</label>
        <div class="col-md-12">
         {{Form::password('confirmPassword', array('class' => 'form-control','placeholder'=>'Confirm Password'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Store</label>
        <div class="col-md-12">
         <select name="store" class="form-control">
            <option>Select Store</option>
            @foreach($empresas as $empresas)
          <option value="{{$empresas->id}}">{{$empresas->nombre}}</option>
            @endforeach
         </select>
        </div>
      </div>


      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">User Role</label>
        <div class="col-md-12">
         {{ Form::select('level', ['' => '-- Select Role --',
         '40' => 'Dresses_Admin'], null, array('class' => 'form-control')) }}
        </div>
      </div>

      <div class="form-group form-actions">
       <div class="col-md-9 col-md-offset-3">
        <button type="submit" class="btn btn-primary"><i class="fa fa-angle-right"></i> Create</button>
        <button type="reset" class="btn btn-warning"><i class="fa fa-angle-right"></i> Cancel</button>
       </div>
      </div>
    
     {{ Form::close() }}
                                
   </div>
  </div>
 </div> <!-- end col -->
</div>










                             
@stop




