<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Repositories\CategoryRepository;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\ClientService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientsController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $clientRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ClientService
     */
    private $clientService;

    public function __construct(ClientRepository $categoryRepository, UserRepository $userRepository, ClientService $clientService)
    {

        $this->clientRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientRepository->paginate();

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        $users = $this->userRepository->lists('name', 'id');

        return view('admin.clients.create', compact('users'));
    }

    public function store(AdminClientRequest $request)
    {

        $data = $request->all();
        $this->clientService->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id)
    {
        $client = $this->clientRepository->find($id);
        $users = $this->userRepository->lists('name', 'id');

        return view('admin.clients.edit', compact('client', 'users'));
    }

    public function update(AdminClientRequest $request, $id)
    {

        $data = $request->all();
        $this->clientService->update($data, $id);

        return redirect()->route('admin.clients.index');
    }

    public function destroy($id)
    {
        $this->clientRepository->delete($id);

        return redirect()->route('admin.clients.index');
    }

    public function getAuthenticated(){

        $id = Authorizer::getResourceOwnerId();

        $user = $this->userRepository->skipPresenter(false)->find($id);

        #dd($user);

        return $user;
    }
}
