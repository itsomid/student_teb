<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductTypeEnum;
use App\Http\Requests\API\Cart\AddToCartRequest;
use App\Http\Resources\StudentPanel\Cart\CartListCollection;
use App\Models\Product;
use App\Services\StudentAccountService;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Exceptions\ItemDoesNotExistsInShoppingCart;
use App\ShoppingCart\Exceptions\ItemExistsInShoppingCart;
use App\ShoppingCart\Exceptions\ItemNotInstallmentableException;
use App\ShoppingCart\Exceptions\ProductDoesNotExistsException;
use App\ShoppingCart\Exceptions\ProductNotCustomPackageException;
use http\Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CartController
{

    /**
     * Get User ID
     * @var int
     */
    private int $userId;

    public function __construct(private StudentAccountService $accountService)
    {
        $this->userId = Auth::guard('student')->id();
    }

    public function lists(): Application|Response|ResponseFactory
    {
        CartAdaptor::init($this->userId);
        $items = CartAdaptor::getItems();
        $userCredit = $this->accountService->getAccount($this->userId);
        return response(
            new CartListCollection($items, $userCredit)
        );
    }

    public function add(AddToCartRequest $request)
    {
        $product = Product::query()->find($request->input('product_id'));

        CartAdaptor::init($this->userId);
        try {
            if ($product->product_type_id === ProductTypeEnum::COURSE) {
                CartAdaptor::addCourse($product->id);
            } elseif ($product->product_type_id === ProductTypeEnum::CUSTOM_PACKAGE) {
                $packagesItem = $request->input('packages');
                $package_products_array = array_map(function ($package) {
                    return $package['product_id'];
                }, $packagesItem);
                CartAdaptor::addPackage($product->id, $package_products_array);
            }
        } catch (ProductDoesNotExistsException) {
            return response(
                ['message' => 'این محصول وجود ندارد.'],
                Response::HTTP_NOT_FOUND
            );
        } catch (ItemExistsInShoppingCart) {
            return response(
                ['message' => 'این محصول قبلا به سبد خرید اضافه شده است.'],
                Response::HTTP_NOT_ACCEPTABLE

            );
        } catch (Throwable $e) {
            report($e);
            return response(
                ['message' => 'مشکلی پیش آمده است لطفادقایقی دیگر تلاش کنید'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            ['message' => 'محصول با موفقیت به سبد خرید اضافه شد.'],
            Response::HTTP_OK
        );
    }

    public function updatePackage(AddToCartRequest $request)
    {
        $product = Product::query()->find($request->input('product_id'));
        CartAdaptor::init($this->userId);
        try {
            if ($product->product_type_id === ProductTypeEnum::CUSTOM_PACKAGE) {
                CartAdaptor::remove($product->id);
                $packagesItem = $request->input('packages');
                $package_products_array = array_map(function ($package) {
                    return $package['product_id'];
                }, $packagesItem);
                CartAdaptor::addPackage($product->id, $package_products_array);
            }
            else{
                throw new ProductNotCustomPackageException();
            }
        } catch (ProductNotCustomPackageException $e) {
            return response(
                ['message' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }catch (ItemDoesNotExistsInShoppingCart) {
            return response(
                ['message' => 'محصول در سبد خرید وجود ندارد.'],
                Response::HTTP_NOT_FOUND
            );
        }catch (ProductDoesNotExistsException) {
            return response(
                ['message' => 'این محصول وجود ندارد.'],
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $e) {
            report($e);
            return response(
                ['message' => 'مشکلی پیش آمده است لطفادقایقی دیگر تلاش کنید'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            ['message' => 'پکیج شما با موفقیت ویرایش شد.'],
            Response::HTTP_OK
        );
    }

    public function changeToInstallmentCart(Request $request)
    {
        $request->validate([
            'is_installment' => ['in:0,1']
        ]);
        $isInstallment = $request->input('is_installment');

        CartAdaptor::init($this->userId);

        try {
            CartAdaptor::changeInstallment($isInstallment);

        } catch (ItemNotInstallmentableException) {
            return response(
                ['message' => 'محصولی قابلیت قسطی شدن را ندارند'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            report($e);
            return response(
                ['message' => 'مشکلی پیش آمده است لطفا دقایقی دیگر تلاش کنید'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $items = CartAdaptor::getItems();
        $userCredit = $this->accountService->getAccount($this->userId);
        return response(
            new CartListCollection($items, $userCredit)
        );
    }

    public function remove(Product $product)
    {
        CartAdaptor::init($this->userId);
        $userCredit = Auth::guard('student')->user()->balance;

        try {
            CartAdaptor::remove($product->id);
        } catch (ItemDoesNotExistsInShoppingCart) {
            return response(
                ['message' => 'محصول در سبد خرید وجود ندارد.'],
                Response::HTTP_NOT_FOUND
            );
        }
        $items = CartAdaptor::getItems();

        return response([
            'data' => new CartListCollection($items, $userCredit),
            'message' => 'محصول با موفقیت از سبد خرید حذف شد.'
        ]);
    }
}
