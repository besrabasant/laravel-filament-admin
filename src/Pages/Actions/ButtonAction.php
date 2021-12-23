<?php

namespace Filament\Pages\Actions;

class ButtonAction extends Action
{
    use Concerns\CanSubmitForm;
    use Concerns\HasIcon;

    protected string $view = 'filament::pages.actions.button-action';

    protected ?string $iconPosition = null;

    protected bool $withLoadingIndicator = true;

    public function iconPosition(string $position): static
    {
        $this->iconPosition = $position;

        return $this;
    }

    public function getIconPosition(): ?string
    {
        return $this->iconPosition;
    }

    public function withoutLoadingIndicator(): static
    {
        $this->withLoadingIndicator = false;

        return $this;
    }

    public function getWithLoadingIndicator(): bool
    {
        return $this->withLoadingIndicator;
    }
}
