@extends('layouts.user')

@section('title', 'Tekete Management System')

@push('styles')
    <link href="{{ asset('/css/bootstrap-4.4.1.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/jAlert.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
@endpush

@push('topscripts')
    <script src="{{ asset('/js/log_ticket.js?v=0.1.1') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '/user/details',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.user && response.user.first_name) {
                        $('#nameNoLable').text(response.user.first_name + ' ' + response.user.last_name);
                        $('#company').text('Company: ' + (response.company ? response.company.c_name : 'N/A'));
                        $('#phoneNoLabel').text('Phone: ' + response.user.mobile);
                    } else {
                        $('#nameNoLable').text('Guest');
                        $('#company').text('Company: Not Available');
                        $('#phoneNoLabel').text('Phone: Not Available');
                    }
                },
                error: function () {
                    $('#nameNoLable').text('Guest');
                    $('#company').text('Company: Error');
                    $('#phoneNoLabel').text('Phone: Error');
                }
            });
        });
    </script>
@endpush

@section('content')
    <h1 class="title">Tekete Management System</h1>
    @if(session('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "{{ url('log_ticket') }}";
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>
    @endif

    <div class="incident-form">
        <form name="frm" id="frm" action="{{ route('log_ticket.submit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <table class="table">
                <tr>
                    <td class="labels">DATE:</td>
                    <td><input type="text" class="input-text" id="date" value="" readonly></td>
                </tr>
                <tr>
                    <td class="labels">Operating System:</td>
                    <td>
                        <select name="os" id="operating-system" required class='input-text'>
                            <option value="">Select</option>
                            <option value="Windows">Windows</option>
                            <option value="Mac">Mac</option>
                            <option value="Android">Android</option>
                            <option value="Linux">Linux</option>
                        </select>
                        <span class="error">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">Department:</td>
                    <td>
                        <select name="department" id="department" required class='input-text'>
                            <option value="">Select</option>
                            <option value="support">Support</option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Development">Development</option>
                            <option value="Business Analysis">Business Analysis</option>
                            <option value="Project Management">Project Management</option>
                        </select>
                        <span class="error">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">Description:</td>
                    <td>
                        <select name="description" id="description" required class='input-text'
                            onchange="toggleOtherField()">
                            <option value="">Select</option>
                            <option value="forgotten password">Forgotten Password</option>
                            <option value="Slow performance">Slow Performance</option>
                            <option value="USB unrecognised">USB Unrecognised</option>
                            <option value="Computer randomly shutsdown">Computer Randomly Shuts Down</option>
                            <option value="Network Problem">Network Problem</option>
                            <option value="Other">Other</option>
                        </select>
                        <span class="error">*</span>
                    </td>
                </tr>
                <tr id="other_te" style="display: none;">
                    <td class="labels">Other:</td>
                    <td>
                        <input id="otherValue" class="input-text" type="text" name="other_text" placeholder="Specify issue">
                        <span class="error">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="labels">Attachment</td>
                    <td><input id="attachment" class="input-text" type="file" name="attachment" accept="image/*"></td>
                </tr>
                <tr>
                    <td><input class="submit_btn" type="submit" name="log" /></td>
                    <td><input class="clear_btn" type="button" onclick="clearField()" value="Clear"></td>
                </tr>
            </table>
        </form>
    </div>
@endsection