@extends('layouts.modals')

@section('modal-content')
<div class="modal fade" id="escalationModal" tabindex="-1" role="dialog" aria-labelledby="escalationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="escalationModalLabel">Escalate Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="escalationForm">
                    <input type="hidden" id="escalateTicketId" name="ticketId">
                    <div class="form-group">
                        <label for="assignedTechnician">Assign Technician*</label>
                        <select class="form-control" id="assignedTechnician" name="technician_id" required>
                            <option value="">Select Technician</option>
                            @foreach($technicians as $technician)
                                <option value="{{ $technician->technician_id }}">
                                    {{ $technician->first_name }} {{ $technician->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="escalationReason">Reason for Escalation*</label>
                        <textarea class="form-control" id="escalationReason" name="reason" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Escalate Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection