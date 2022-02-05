<?php

namespace Filament\Resources\Pages;

use Filament\Forms\ComponentContainer;
use Filament\Pages\Actions\ButtonAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property ComponentContainer $form
 */
class EditRecord extends Page
{
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasRelationManagers;
    use Concerns\InteractsWithRecord;
    use Concerns\UsesResourceForm;

    protected static string $view = 'filament::resources.pages.edit-record';

    public $record;

    public $data;

    protected $queryString = [
        'activeRelationManager',
    ];

    public function getBreadcrumb(): string
    {
        return static::$breadcrumb ?? __('filament::resources/pages/edit-record.breadcrumb');
    }

    public function mount($record): void
    {
        static::authorizeResourceAccess();

        $this->record = $this->getRecord($record);

        abort_unless(static::getResource()::canEdit($this->record), 403);

        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $data = $this->record->toArray();

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    public function save(bool $shouldRedirect = true): void
    {
        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeSave($data);

        $this->callHook('beforeSave');

        $this->handleRecordUpdate($this->record, $data);

        $this->callHook('afterSave');

        if ($shouldRedirect && ($redirectUrl = $this->getRedirectUrl())) {
            $this->redirect($redirectUrl);
        } else {
            $this->notify('success', __('filament::resources/pages/edit-record.messages.saved'));
        }
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function openDeleteModal(): void
    {
        $this->dispatchBrowserEvent('open-modal', [
            'id' => 'delete',
        ]);
    }

    public function delete(): void
    {
        abort_unless(static::getResource()::canDelete($this->record), 403);

        $this->callHook('beforeDelete');

        $this->record->delete();

        $this->callHook('afterDelete');

        $this->redirect($this->getDeleteRedirectUrl());
    }

    protected function getActions(): array
    {
        $resource = static::getResource();

        return array_merge(
            ($resource::canView($this->record) ? [$this->getViewButtonAction()] : []),
            ($resource::canDelete($this->record) ? [$this->getDeleteButtonAction()] : []),
        );
    }

    protected function getViewButtonAction(): ButtonAction
    {
        return ButtonAction::make('view')
            ->label(__('filament::resources/pages/edit-record.actions.view.label'))
            ->url(fn () => static::getResource()::getUrl('view', ['record' => $this->record]))
            ->color('secondary');
    }

    protected function getDeleteButtonAction(): ButtonAction
    {
        return ButtonAction::make('delete')
            ->label(__('filament::resources/pages/edit-record.actions.delete.label'))
            ->requiresConfirmation()
            ->modalHeading(__('filament::resources/pages/edit-record.actions.delete.modal.heading', ['label' => $this->getRecordTitle() ?? static::getResource()::getLabel()]))
            ->modalSubheading(__('filament::resources/pages/edit-record.actions.delete.modal.subheading'))
            ->modalButton(__('filament::resources/pages/edit-record.actions.delete.modal.buttons.delete.label'))
            ->action('delete')
            ->color('danger');
    }

    protected function getTitle(): string
    {
        if (filled(static::$title)) {
            return static::$title;
        }

        if (filled($recordTitle = $this->getRecordTitle())) {
            return __('filament::resources/pages/edit-record.title', [
                'label' => $recordTitle,
            ]);
        }

        return __('filament::resources/pages/edit-record.title', [
            'label' => Str::title(static::getResource()::getLabel()),
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveButtonFormAction(),
            $this->getCancelButtonFormAction(),
        ];
    }

    protected function getSaveButtonFormAction(): ButtonAction
    {
        return ButtonAction::make('save')
            ->label(__('filament::resources/pages/edit-record.form.actions.save.label'))
            ->submit('save');
    }

    protected function getCancelButtonFormAction(): ButtonAction
    {
        return ButtonAction::make('cancel')
            ->label(__('filament::resources/pages/edit-record.form.actions.cancel.label'))
            ->url(static::getResource()::getUrl())
            ->color('secondary');
    }

    protected function getForms(): array
    {
        return array_merge(parent::getForms(), [
            'form' => $this->makeForm()
                ->model($this->record)
                ->schema($this->getResourceForm()->getSchema())
                ->statePath('data'),
        ]);
    }

    protected function getRedirectUrl(): ?string
    {
//        return null;

        $resource = static::getResource();

        if (!$resource::canView($this->record)) {
            return null;
        }

        return $resource::getUrl('view', ['record' => $this->record]);
    }

    protected function getDeleteRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }
}
