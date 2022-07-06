@component('admin.layouts.content' , ['title' => 'لیست کاربران'])
    @slot('breadcrumb')
    <li class="breadcrumb-item active"><a href="/admin">پنل مدیریت</a></li>
    <li class="breadcrumb-item active">لیست کاربران</li>
    
    @endslot 
    <div class="row"> 
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول ریسپانسیو</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="جستجو">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                    <th>آیدی کاربر</th>
                    <th>نام کاربر</th>
                    <th>ایمیل</th>
                    <th>وضعیت ایمیل</th>
                    <th>اقدامات</th>
                  </tr>
                 
                  @foreach($users as $user)
                  <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                     @if($user->email_verified_at)
                        <td><span class="badge badge-success">فعال</span></td>
                     @else
                     <td><span class="badge badge-danger">غیرفعال</span></td>
                     @endif
                    <td>
                        <a href="#" class="btn btn-sm btn-danger">حذف</a>
                        <a href="#" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

@endcomponent
