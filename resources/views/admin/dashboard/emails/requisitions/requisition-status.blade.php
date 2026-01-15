<!DOCTYPE html>
<html>
<body style="font-family: Arial">
    <h2>Requisition Status Update</h2>

    <p>Dear {{ $req->requestedBy->name }},</p>

    <p>Your vehicle requisition request has been updated.</p>

    <table>
        <tr><td><b>ID:</b></td> <td>#{{ $req->id }}</td></tr>
        <tr><td><b>Date:</b></td> <td>{{ $req->travel_date }}</td></tr>
        <tr><td><b>From:</b></td> <td>{{ $req->from_location }}</td></tr>
        <tr><td><b>To:</b></td> <td>{{ $req->to_location }}</td></tr>
        <tr><td><b>New Status:</b></td> <td>{{ $newStatus }}</td></tr>
    </table>

    @if($comment)
    <p><b>Comment:</b> "{{ $comment }}"</p>
    @endif

    <p>Thank you,<br>Transport Management System</p>
</body>
</html>
