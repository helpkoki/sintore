$(document).ready(function () {
    console.log("jQuery is loaded and script is running.");

    // Force remove any existing modal backdrops
    // $('.modal-backdrop').remove();
    // $('body').removeClass('modal-open');

    // Handle ticket row click (to show ticket_modal)
    $('.clickable-row').on('click', function (e) {
        // Ensure user is NOT clicking on the status dropdown
        if ($(e.target).hasClass('status-select') || $(e.target).closest('.status-select').length) {
            return;
        }

        const ticketId = $(this).data('ticket-id');
        console.log("Opening Ticket Modal for:", ticketId);
        showTicketModal(ticketId);
    });

    // Handle status change (to show escalation_modal)
    $('.status-select').on('change', function () {
        const ticketId = $(this).data('ticket-id');
        const newStatus = $(this).val();

        console.log(`Status changed for Ticket ${ticketId}: ${newStatus}`);

        if (newStatus === 'Escalate') {
            console.log('Attempting to show escalation modal');
            forceShowEscalationModal(ticketId);
        } else {
            updateTicketStatus(ticketId, newStatus);
        }
    });

    // Handle escalation form submission
    $('#escalationForm').on('submit', function (e) {
        e.preventDefault();

        const ticketId = $('#escalateTicketId').val();
        const technicianId = $('#assignedTechnician').val();
        const reason = $('#escalationReason').val();

        escalateTicket(ticketId, technicianId, reason);
    });

    // Generic close button handler
    $('.modal .close, .modal .btn-secondary').on('click', function() {
        $(this).closest('.modal').modal('hide');
    });

    // Handle modal cleanup after hiding
    $('.modal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $(this).find('form').trigger('reset');
    });
    
});

function forceShowEscalationModal(ticketId) {
    console.log("Force showing escalation modal for:", ticketId);

    // First, ensure any other modals are hidden
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');

    // Set the ticket ID
    $('#escalateTicketId').val(ticketId);

    // Ensure the modal is visible
    const $modal = $('#escalationModal');

    if ($modal.length === 0) {
        console.error("Escalation modal not found in DOM.");
        return;
    }

    console.log("Escalation modal found, attempting to show...");

    // Show the modal with enforced settings
    $modal.css('display', 'block');

    $modal.modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });

     $('.modal .close, .modal .btn-secondary').on('click', function() {
        $('#escalationModal').modal('hide');
        $('#ticketModal').modal('hide');
    });
    // Backup method: Ensure modal is forcefully displayed after 200ms
    setTimeout(() => {
        if (!$modal.hasClass('show')) {
            console.log("Manually forcing modal display...");
            $modal.addClass('show');
            $('body').addClass('modal-open');
            $('<div class="modal-backdrop fade show"></div>').appendTo(document.body);
        }
    }, 200);
}

function showTicketModal(ticketId) {
    console.log("Fetching ticket details for:", ticketId);

    // Hide any visible modals first
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();

    $('#ticketModal').modal('show');

    // Fetch and populate ticket details
    $.get(`/technician/ticket/${ticketId}`, function (data) {
        console.log("Ticket Data Received:", data);

        $('#modal-ticket-number').text(`${data.date}/${data.tick_id}`);
        $('#modal-name').text(`${data.first_name} ${data.last_name}`);
        $('#modal-mobile').text(data.mobile || 'N/A');
        $('#modal-email').text(data.email || 'N/A');
        $('#modal-os').text(data.os || 'N/A');
        $('#modal-description').text(data.description || 'No description available');
        $('#modal-department').text(data.department || 'N/A');
        $('#modal-status').text(data.status || 'N/A');
        $('#modal-date').text(data.date || 'N/A');
        $('#modal-company').text(data.company_name || 'N/A');
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error('Error fetching ticket data:', textStatus, errorThrown);
        alert('Error loading ticket details. Please try again.');
        $('#ticketModal').modal('hide');
    });
}

// Function to escalate the ticket
function escalateTicket(ticketId, technicianId, reason) {
    console.log("Submitting escalation request for:", { ticketId, technicianId, reason });

    $.ajax({
        url: `/technician/ticket/${ticketId}/escalate`,
        method: 'POST',
        data: {
            technician_id: technicianId,
            reason: reason,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function (response) {
            if (response.success) {
                alert('Ticket has been successfully escalated!');
                updateTicketStatus(ticketId, 'Escalate');
                $('#escalationModal').modal('hide');
                $('#escalationForm')[0].reset();
            }
        },
        error: function (xhr) {
            console.error("Escalation error:", xhr.responseJSON.message);
            alert('Error escalating ticket: ' + xhr.responseJSON.message);
        }
    });
}

// Function to update the ticket status
function updateTicketStatus(ticketId, newStatus) {
    console.log(`Updating ticket status for ${ticketId} to ${newStatus}`);

    $.ajax({
        url: `/technician/ticket/${ticketId}/status`,
        method: 'POST',
        data: {
            status: newStatus,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function (response) {
            if (response.success) {
                alert(`Status has been successfully updated to ${newStatus}!`);

                // Redirect based on the new status
                setTimeout(() => {
                    let redirectUrl;
                    switch (newStatus) {
                        case 'Logged':
                            redirectUrl = '/technician/logged';
                            break;
                        case 'In-Progress':
                            redirectUrl = '/technician/in_progress';
                            break;
                        case 'Escalate':
                            redirectUrl = '/technician/escalated';
                            break;
                        case 'Completed':
                            redirectUrl = '/technician/completed';
                            break;
                    }
                    if (redirectUrl) {
                        console.log("Redirecting to:", redirectUrl);
                        window.location.href = redirectUrl;
                    }
                }, 1000);
            }
        },
        error: function (xhr) {
            console.error("Status update error:", xhr.responseJSON.message);
            alert('Error updating status: ' + xhr.responseJSON.message);
        }
    });
}