@extends('admin.layout')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blank page
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Листинг сущности</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="create.html" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Пост</th>
                  <th>Текст</th>
                  <th>Одобрить</th>
                  <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($comments as $comment)
                <tr>
                  <td>{{$comment->id}}</td>
                  <td>{{$comment->post->title}}</td>
                  <td>{{$comment->text}}</td>
                  @if($comment->status == 1)
                  	<td><a href="/admin/comments/toggle/{{$comment->id}}" class="fa fa-thumbs-o-up"></a></td>
                  @else
                  	<td><a href="/admin/comments/toggle/{{$comment->id}}" class="fa fa-lock"></a></td>
                  @endif
                  <td>
                     {{ Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'delete']) }}
	                     <button class="delete" onclick="return confirm('Вы уверены?')"><i class="fa fa-remove"></i></button>
                     {{ Form::close() }}
                  </td>
                </tr>
				@endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection