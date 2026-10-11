 <!-- latest jquery-->
 <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
 <!-- Bootstrap js-->
 <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
 <!-- feather icon js-->
 <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
 <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
 <!-- scrollbar js-->
 <script src="{{ asset('assets/js/scrollbar/simplebar.min.js') }}"></script>
 <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
 <!-- Sidebar jquery-->
 <script src="{{ asset('assets/js/config.js') }}"></script>
 <!-- Plugins JS start-->
 <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
 <script src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
 <script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
 <script src="{{ asset('assets/js/slick/slick.js') }}"></script>
 <script src="{{ asset('assets/js/header-slick.js') }}"></script>
 @yield('scripts')
 <script src="{{ asset('assets/js/script.js') }}"></script>
 <script src="{{ asset('assets/js/script1.js') }}"></script>
 <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
 <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

 <!-- Status Update-->
  <script>
     $(document).ready(function() {
         $(document).on('change', '.toggle-status', function() {
             
             let status = $(this).prop('checked') ? 1 : 0;
             let url = $(this).data('route');
             let clickedToggle = $(this);
             $.ajax({
                 type: "PUT",
                 url: url,
                 data: {
                     status: status,
                     _token: '{{ csrf_token() }}',
                 },
                 success: function(data) {
                     clickedToggle.prop('checked', status);
                     toastr.success("Status Updated Successfully");
                 },
                 error: function(xhr, status, error) {
                     console.log(error)
                 }
             });
         });
     });
 </script>

 <!-- Notification Actions -->
 <script>
     $(document).ready(function() {
         // Mark a single notification as read
         $(document).on('click', '.mark-read', function(e) {
             e.preventDefault();
             var url = $(this).data('url');
             var $li = $(this).closest('li[data-notification-id]');
             $.ajax({
                 type: "POST",
                 url: url,
                 data: {
                     _token: '{{ csrf_token() }}',
                 },
                 success: function(data) {
                     $li.removeClass('b-l-primary').addClass('b-l-secondary');
                     $li.find('.mark-read').remove();
                     updateUnreadCount();
                 },
                 error: function(xhr) {
                     console.log('Error marking notification as read:', xhr);
                 }
             });
         });

         // Delete a notification
         $(document).on('click', '.delete-notification', function(e) {
             e.preventDefault();
             var url = $(this).data('url');
             var $li = $(this).closest('li[data-notification-id]');
             if (confirm('Are you sure you want to delete this notification?')) {
                 $.ajax({
                     type: "DELETE",
                     url: url,
                     data: {
                         _token: '{{ csrf_token() }}',
                     },
                     success: function(data) {
                         $li.fadeOut(300, function() {
                             $(this).remove();
                             updateUnreadCount();
                             checkEmptyList();
                         });
                     },
                     error: function(xhr) {
                         console.log('Error deleting notification:', xhr);
                     }
                 });
             }
         });

         // Mark all notifications as read
         $(document).on('click', '.mark-all-read', function(e) {
             e.preventDefault();
             var url = $(this).data('url');
             $.ajax({
                 type: "POST",
                 url: url,
                 data: {
                     _token: '{{ csrf_token() }}',
                 },
                 success: function(data) {
                     $('#notification-list li').removeClass('b-l-primary').addClass('b-l-secondary');
                     $('#notification-list li .mark-read').remove();
                     updateUnreadCount();
                     $('.mark-all-read').hide();
                 },
                 error: function(xhr) {
                     console.log('Error marking all notifications as read:', xhr);
                 }
             });
         });

         function updateUnreadCount() {
             var unreadCount = $('#notification-list li.b-l-primary').length;
             $('#notification-badge').text(unreadCount);
             if (unreadCount === 0) {
                 $('#notification-badge').hide();
             } else {
                 $('#notification-badge').show();
             }
         }

         function checkEmptyList() {
             if ($('#notification-list li').length === 0) {
                 $('#notification-list').append('<li class="text-center p-3"><p class="mb-0 f-14 text-muted">No notifications</p></li>');
             }
         }
     });
 </script>
