<?php

namespace FrontFiles\Http\Requests;

use FrontFiles\{
    File, TagWhat, TagWho, Utility\Helper
};
use Illuminate\Foundation\Http\FormRequest;

class UpdateFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Corrects data.
     *
     * @return array
     */
    protected function validationData(): array
    {
        $all = parent::validationData();

        if(is_string($what = array_get($all, 'what')))
            $what = json_decode($what, true);

        if(is_string($who = array_get($all, 'who')))
            $who = json_decode($who, true);

        $all['what'] = $what;
        $all['who'] = $who;

        return $all;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string|max:175',
            'description'   => 'required|string',
            'where'         => 'required|string|max:175',
            'when'          => 'required|date',
            'what.*'        => 'required|string|max:25',
            'who.*'         => 'required|string|max:25',
            'why'           => 'nullable|string|max:160',
        ];
    }

    /**
     * Updates the file.
     *
     * @param File $file
     * @return mixed
     */
    public function persist(File $file)
    {
        $file->update([
            'title'         => request('title'),
            'description'   => request('description'),
            'where'         => request('where'),
            'when'          => request('when'),
            'why'           => request('why'),
        ]);

        $file->tagsWhat()->sync(
            Helper::getTagIds(request('what'), TagWhat::class)
        );

        $file->tagsWho()->sync(
            Helper::getTagIds(request('who'), TagWho::class)
        );

        if(request()->expectsJson())
            return response(['status' => 'File successfully edited!'], 200);

        return redirect()
            ->route('files')
            ->with('message', 'File successfully updated.');
    }
}
