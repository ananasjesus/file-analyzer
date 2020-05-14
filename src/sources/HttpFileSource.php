<?php


namespace File\Analyzer\sources;


class HttpFileSource extends LocalFileSource
{
    const CONTENT_TYPE_HEADER = 'Content-Type';
    const CONTENT_LENGTH_HEADER = 'Content-Length';

    private array $headers = [];

    private function getHeaders(): array
    {
        if (empty($this->headers)) {
            $headersList = get_headers($this->config['filePath']);

            if (!is_array($headersList)) {
                return [];
            }

            $this->headers = array_reduce(
                $headersList,
                function ($result, $headerString) {
                    $headerArray = explode(': ', $headerString);
                    if (count($headerArray) > 1) {
                        $result[$headerArray[0]] = $headerArray[1];
                    } else {
                        $result[] = $headerString;
                    }
                    return $result;
                },
                []
            );
        }
        return $this->headers;
    }

    public function getFileSize(): int
    {
        if (array_key_exists(self::CONTENT_LENGTH_HEADER, $this->getHeaders())) {
            return $this->getHeaders()[self::CONTENT_LENGTH_HEADER];
        }
        return false;
    }

    public function getFileMimeType(): string
    {
        if (array_key_exists(self::CONTENT_TYPE_HEADER, $this->getHeaders())) {
            return $this->getHeaders()[self::CONTENT_TYPE_HEADER];
        }
        return false;
    }
}