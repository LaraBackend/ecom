@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Commissions  </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">Commissions</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Commissions </h3>

          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		  @if (count($errors) > 0)
                          @if($errors->any())
                            <div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              {{$errors->first()}}
                            </div>
                          @endif
                      @endif

              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Product</th>
                      <th>Commission</th>
                      <th>Level</th>
                      <th>From User ID</th>
                      <th>Status</th>
                      <th>Created at</th>

                    </tr>
                  </thead>
                  <tbody>
                  @if(count($commissions)>0)
                    @foreach ($commissions as $commission)
                        <tr>

                            <td>{{$commission->user_id}} - {{$commission->user['customers_firstname']}}</td>
                            <td>{{$commission->product_id}} </td>
                            <td>{{$commission->commission}}</td>
                            <td>{{$commission->level}}</td>
                            <td>{{$commission->from_user_id}} - {{$commission->from_user['customers_firstname']}}</td>
                            <td>{{$commission->status}}</td>
                            <td>{{$commission->created_at}}</td>

                        </tr>
                    @endforeach
                    @else
                       <tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$commissions->links()}}
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
    <!-- Main row --> 
    


    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 