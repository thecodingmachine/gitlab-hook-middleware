<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Change extends AbstractObject
{

    /**
     * @var Label[]
     */
    private $labelsPrevious = [];

    /**
     * @var Label[]
     */
    private $labelsCurrent = [];

    /**
     * Repository constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        if ($this->hasAttribute('labels')) {
            $labels = $this->getAttribute('labels');
            foreach ($labels['previous'] as $label) {
                $this->labelsPrevious[] = new Label($label);
            }
            foreach ($labels['current'] as $label) {
                $this->labelsCurrent[] = new Label($label);
            }
        }
    }

    /**
     * @return string[]
     */
    public function getUpdatedById(): array
    {
        return $this->getAttribute('updated_by_id');
    }

    /**
     * @return \DateTimeImmutable[]
     */
    public function getUpdatedAt(): array
    {
        return $this->getArrayDateTimeAttribute('updated_at');
    }

    /**
     * @return Label[]
     */
    public function getLabelsPrevious(): array
    {
        return $this->labelsPrevious;
    }

    /**
     * @return Label[]
     */
    public function getLabelsCurrent(): array
    {
        return $this->labelsCurrent;
    }
}
