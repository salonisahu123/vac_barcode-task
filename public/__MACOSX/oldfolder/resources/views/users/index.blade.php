<!DOCTYPE html>
<html lang="en">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <body class="dashboard dashboard_1">
      <!--<div class="full_container">-->
         <!--<div class="inner_container">-->
            <!-- Sidebar  -->
            <x-sidebar />
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
             <x-header />
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                 <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Tables</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                     <div class="row">
                     
                        <!-- table section -->
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Barcode Report</h2>
                                      </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                               <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>SI No.</th>
                                                <th>WO No.</th>
                                                <th>Part No.</th>
                                                <th>SO No.</th>
                                                <th>Line No.</th>
                                                <th>Operation Code</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $index => $user)
                                            <tr>
                                                  <td>{{ $user->firstItem() + $index }}</td><!-- Serial Number -->
                                                
                                                <td>
                                                   <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn cur-p btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                </form>  </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                           
<!-- Pagination Links -->
<div class="d-flex justify-content-between">
    <div>
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
    </div>
    <div>
        {{ $users->links() }} <!-- This generates the pagination links -->
    </div>
</div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            
                  <!-- footer -->
             <x-footer />
               </div>
               <!-- end dashboard inner -->
            </div>
         </div>
      </div>
   
   </body>
</html>