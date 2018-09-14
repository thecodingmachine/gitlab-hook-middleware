<?php
namespace TheCodingMachine\GitlabHook\Model;

use TheCodingMachine\GitlabHook\GitlabHookException;

abstract class AbstractObject
{

    /**
     * @var mixed[]
     */
    protected $payload = [];

    /**
     * @var mixed[]
     */
    protected $objectAttributes = [];

    /**
     * Object constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
        if (isset($payload['object_attributes'])) {
            $this->objectAttributes = $payload['object_attributes'];
        }
    }

    /**
     * @return mixed[]
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param string $key
     * @param string|null $subArray
     *
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    protected function getDateTimeAttribute(string $key, string $subArray = null): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->getAttribute($key, $subArray));
    }

    /**
     * @param string $key
     * @param string|null $subArray
     *
     * @return \DateTimeImmutable|null
     */
    protected function getDateTimeOrNullAttribute(string $key, string $subArray = null): ?\DateTimeImmutable
    {
        if ($attribute = $this->getAttribute($key, $subArray)) {
            return new \DateTimeImmutable($attribute);
        }
        return null;
    }

    /**
     * @param string $key
     * @param string|null $subArray
     *
     * @return \DateTimeImmutable[]
     */
    protected function getArrayDateTimeAttribute(string $key, string $subArray = null): array
    {
        $array = $this->getAttribute($key, $subArray);
        foreach ($array as $key => $value) {
            $array[$key] = new \DateTimeImmutable($value);
        }
        return $array;
    }

    /**
     * @param string $key
     * @param string|null $subArray
     *
     * @return mixed
     */
    protected function getAttribute(string $key, string $subArray = null)
    {
        if (null !== $subArray) {
            $array = $this->getKey($subArray, $this->payload);
        } else {
            $array = $this->payload;
        }
        return $this->getKey($key, $array);
    }

    /**
     * @param string $key
     * @param mixed[] $array
     *
     * @return mixed
     * @throws \TheCodingMachine\GitlabHook\GitlabHookException
     */
    private function getKey(string $key, array $array)
    {
        if (!array_key_exists($key, $array)) {
            throw new GitlabHookException("Variable ".$key." doesn't exist in ".get_class($this)." model");
        }
        return $array[$key];
    }
}
