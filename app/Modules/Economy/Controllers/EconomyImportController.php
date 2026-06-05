<?php

namespace App\Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Economy\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EconomyImportController extends Controller
{
    public function index(): View
    {
        return view('economy::import');
    }

    public function preview(Request $request): View|RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $path = $request->file('csv_file')->store('csv-imports');
        $headers = [];
        $rows = [];
        $delimiter = $this->detectDelimiter(Storage::path($path));

        if (($handle = fopen(Storage::path($path), 'r')) !== false) {
            $headers = fgetcsv($handle, 0, $delimiter);

            $count = 0;
            while (($data = fgetcsv($handle, 0, $delimiter)) !== false && $count < 10) {
                if (count($data) === count($headers)) {
                    $rows[] = array_combine($headers, $data);
                    $count++;
                }
            }
            fclose($handle);
        }

        $dbFields = [
            'data' => 'Data (obbligatorio)',
            'importo' => 'Importo (obbligatorio)',
            'descrizione' => 'Descrizione',
            'note' => 'Note',
        ];

        return view('economy::import', compact('headers', 'rows', 'dbFields', 'path'));
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'path' => ['required', 'string'],
            'mapping' => ['required', 'array'],
        ]);

        if (!Storage::exists($request->path)) {
            return back()->withErrors(['error' => 'File CSV non trovato. Ricarica il file.']);
        }

        $delimiter = $this->detectDelimiter(Storage::path($request->path));
        $mapping = array_filter($request->mapping);
        $imported = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            if (($handle = fopen(Storage::path($request->path), 'r')) !== false) {
                $headers = fgetcsv($handle, 0, $delimiter);

                $lineNumber = 1;
                while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                    $lineNumber++;

                    if (count($data) !== count($headers)) {
                        $errors[] = "Riga $lineNumber: numero colonne non valido.";
                        continue;
                    }

                    $row = array_combine($headers, $data);
                    $record = [];

                    foreach ($mapping as $dbField => $csvColumn) {
                        $record[$dbField] = $row[$csvColumn] ?? null;
                    }

                    if (empty($record['data'])) {
                        $errors[] = "Riga $lineNumber: data mancante.";
                        continue;
                    }

                    if (empty($record['importo']) || !is_numeric($record['importo'])) {
                        $errors[] = "Riga $lineNumber: importo non valido.";
                        continue;
                    }

                    Transaction::create([
                        'data' => $record['data'],
                        'importo' => (float) $record['importo'],
                        'descrizione' => $record['descrizione'] ?? null,
                        'note' => $record['note'] ?? null,
                    ]);

                    $imported++;
                }

                fclose($handle);
            }

            Storage::delete($request->path);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::delete($request->path);

            return back()->withErrors(['error' => 'Errore durante l\'importazione: ' . $e->getMessage()]);
        }

        $message = "$imported movimenti importati con successo.";
        if (!empty($errors)) {
            $message .= ' ' . count($errors) . ' righe saltate.';
        }

        return redirect()->route('economy.transactions.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    private function detectDelimiter(string $path): string
    {
        $content = file_get_contents($path);
        $delimiters = [';' => 0, ',' => 0, "\t" => 0];

        foreach ($delimiters as $delim => $count) {
            $lines = explode("\n", $content);
            if (!empty($lines[0])) {
                $delimiters[$delim] = substr_count($lines[0], $delim);
            }
        }

        return array_search(max($delimiters), $delimiters) ?: ',';
    }
}
