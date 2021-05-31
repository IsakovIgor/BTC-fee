<?php

namespace App\Controller;

use App\Calculator\ParamsCalculatorTrait;
use App\Model\ExternalSourceInterface;
use App\Service\ExternalApi\ExternalApi;
use App\Service\ExternalApi\ExternalApiInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    use ParamsCalculatorTrait;

    private ExternalApiInterface $api;
    private LoggerInterface $logger;

    public function __construct(ExternalApiInterface $api, LoggerInterface $logger)
    {
        $this->api = $api;
        $this->logger = $logger;
    }

    /**
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $hasErrors = false;
        $blocks = [];

        try {
            $blocks = $this->getApi()->getLastBlocks();
        } catch (\Exception $e) {
            $this->getLogger()->error($e);
            $hasErrors = true;
        }

        $params = $this->calculateParams($blocks);

        return $this->render('index/index.html.twig', [
            'hasErrors' => $hasErrors,
            'params'    => $params,
            'blocks'    => \array_map(
                fn(ExternalSourceInterface $b) => [$b->getId(), (int) $b->getFee(), (float) $params->getAvg()], $blocks
            ),
        ]);
    }

    /**
     * @return ExternalApi
     */
    protected function getApi(): ExternalApi
    {
        return $this->api;
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
