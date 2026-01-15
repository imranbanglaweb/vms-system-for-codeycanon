use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

public function returnDocument(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'returner_name' => 'required|string|max:255',
        'document_id' => 'required|integer|exists:documents,id',
        'return_witness' => 'required|string|max:255',
        'submitter_name' => 'required|string|max:255',
        'returned_documents' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:8242880',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $document = Document::findOrFail($id);
    // Handle file upload
    if ($request->hasFile('returned_documents')) {
        $file = $request->file('returned_documents');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('documents/returns', $filename, 'public');
        $document->returned_documents = $filename;
    }

    $document->returner_name = $request->input('returner_name');
    $document->document_id = $request->input('document_id');
    $document->return_witness = $request->input('return_witness');
    $document->submitter_name = $request->input('submitter_name');
    $document->status = 'returned';
    $document->save();

    return redirect()->route('documents.index')->with('success', 'Document returned successfully.');
}
