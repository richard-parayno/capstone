namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    public function collection()
    {
        return Invoice::all();
    }
}