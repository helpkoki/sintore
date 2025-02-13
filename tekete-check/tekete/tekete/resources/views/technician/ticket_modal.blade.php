@extends('layouts.modals')

@section('modal-content')
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Ticket Number:</th>
                        <td id="modal-ticket-number"></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td id="modal-name"></td>
                    </tr>
                    <tr>
                        <th>Cell Number:</th>
                        <td id="modal-mobile"></td>
                    </tr>
                    <tr>
                        <th>Email Address:</th>
                        <td id="modal-email"></td>
                    </tr>
                    <tr>
                        <th>Operating System:</th>
                        <td id="modal-os"></td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td id="modal-description"></td>
                    </tr>
                    <tr>
                        <th>Department:</th>
                        <td id="modal-department"></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td id="modal-status"></td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td id="modal-date"></td>
                    </tr>
                    <tr>
                        <th>Company Name:</th>
                        <td id="modal-company"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection