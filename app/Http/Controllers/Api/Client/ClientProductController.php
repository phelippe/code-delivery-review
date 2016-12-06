<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientProductController extends Controller
{


    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
      $this->productRepository = $productRepository;
    }

    public function index()
    {
      $products = $this->productRepository->skipPresenter(false)->all();

      return $products;
    }

}
