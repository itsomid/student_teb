<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductTypeEnum;
use App\Http\Requests\API\Cart\AddToCartRequest;
use App\Http\Resources\StudentPanel\Cart\CartListCollection;
use App\Models\Account;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use App\Services\StudentAccountService;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Exceptions\CouponNotUsableException;
use App\ShoppingCart\Exceptions\CouponNotUsableProductNotApplicable;
use App\ShoppingCart\Exceptions\CouponNotUsableUserNotApplicable;
use App\ShoppingCart\Exceptions\ItemDoesNotExistsInShoppingCart;
use App\ShoppingCart\Exceptions\ItemExistsInShoppingCart;
use App\ShoppingCart\Exceptions\ItemNotInstallmentableException;
use App\ShoppingCart\Exceptions\ProductDoesNotExistsException;
use App\ShoppingCart\Exceptions\ProductNotCustomPackageException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartController
{

    /**
     * Get User ID
     * @var int
     */
    private int $userId;

    public function __construct(private readonly StudentAccountService $accountService)
    {
        $this->userId = Auth::guard('student')->id();
    }

    public function lists()
    {

        CartAdaptor::init($this->userId);
        CartAdaptor::removeInstallment();
        $items = CartAdaptor::getItems();
        $userCredit = $this->accountService->getBalance($this->userId);
//        dd($items[0]->getModel()->packages[0]-, $items);
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
            } else {
                throw new ProductNotCustomPackageException();
            }
        } catch (ProductNotCustomPackageException $e) {
            return response(
                ['message' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        } catch (ItemDoesNotExistsInShoppingCart) {
            return response(
                ['message' => 'محصول در سبد خرید وجود ندارد.'],
                Response::HTTP_NOT_FOUND
            );
        } catch (ProductDoesNotExistsException) {
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

//            $items = CartAdaptor::getItems();
//            $userCredit = $this->accountService->getBalance($this->userId);
//            return response(
//                new CartListCollection($items, $userCredit)
//            );
            CartAdaptor::changeInstallment($isInstallment);
            if ($isInstallment){
                return response(['message' => 'سبد خرید با موفقیت قسطی شد.'], Response::HTTP_OK);
            }
            else{
                return response(['message' => 'سبد خرید با موفقیت نقدی شد.'], Response::HTTP_OK);
            }
        } catch (ItemNotInstallmentableException) {
            return response(
                ['message' => 'یک یا چند محصول از سبد خرید قابلیت قسطی شدن را ندارد'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            report($e);
            return response(
                ['message' => 'مشکلی پیش آمده است لطفا دقایقی دیگر تلاش کنید'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function remove(Product $product)
    {
        CartAdaptor::init($this->userId);
        $userCredit = $this->accountService->getBalance($this->userId);

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

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_name' => ['required', 'exists:coupons,coupon_name']
        ]);
        $couponName = $request->input('coupon_name');
        CartAdaptor::init($this->userId);

        try {
            DB::beginTransaction();
            $coupon = Coupon::query()->where('coupon_name', $couponName)->first();

            CartAdaptor::applyCoupon($coupon->id);
            DB::commit();
        } catch (CouponNotUsableUserNotApplicable) {
            DB::rollBack();
            return response(['message' => 'کد تخفیف برای شما قابل استفاده نیست.'], Response::HTTP_NOT_ACCEPTABLE);
        } catch (CouponNotUsableProductNotApplicable) {
            DB::rollBack();
            return response(['message' => 'هیچ کدام از محصولات سبد خرید قابلیت استفاده از کد تخفیف را ندارند.',], Response::HTTP_NOT_ACCEPTABLE);
        } catch (CouponNotUsableException) {
            DB::rollBack();
            return response(['message' => 'کد تخفیف قابل استفاده نمی باشد.'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            report($exception);
            return response(['message' => 'مشکل فنی رخ داده است لطفا بعدا تلاش کنید.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['message' => 'کد تخفیف باموفقیت اعمال شد.'], Response::HTTP_OK);
    }

    public function removeCoupon(Request $request)
    {

        $request->validate([
            'coupon_name' => ['required', 'exists:coupons,coupon_name']
        ]);

        $couponName = $request->input('coupon_name');
        CartAdaptor::init($this->userId);

        try {
            DB::beginTransaction();
            $coupon = Coupon::query()->where('coupon_name', $couponName)->first();

            CartAdaptor::removeCoupon($coupon->id);
            DB::commit();
        } catch (CouponNotUsableException) {
            DB::rollBack();
            return response(['message' => 'کد تخفیف قابل استفاده نمی باشد.'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            report($exception);
            return response(['message' => 'مشکل فنی رخ داده است لطفا بعدا تلاش کنید.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['message' => 'کد تخفیف با موفقیت حذف شد.'], Response::HTTP_OK);
    }
}
