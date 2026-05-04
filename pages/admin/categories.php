<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$file = __DIR__ . '/../../data/categories.json';

function readCategories(string $path): array
{
    if (!file_exists($path)) {
        return [];
    }
    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function writeCategories(string $path, array $categories): void
{
    file_put_contents($path, json_encode(array_values($categories), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function makeSlug(string $name): string
{
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) $slug, '-');
    return $slug ?: 'category';
}

$categories = readCategories($file);
$flash = '';
$flashType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'add') {
        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $status = (string) ($_POST['status'] ?? 'active');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($name === '') {
            $flash = 'Category name is required.';
            $flashType = 'error';
        } else {
            $newId = 1;
            foreach ($categories as $category) {
                $newId = max($newId, (int) ($category['id'] ?? 0) + 1);
            }

            if ($slug === '') {
                $slug = makeSlug($name);
            }

            $existingSlugs = array_map(static fn($c) => (string) ($c['slug'] ?? ''), $categories);
            if (in_array($slug, $existingSlugs, true)) {
                $slug .= '-' . $newId;
            }

            $categories[] = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'sort_order' => $sortOrder,
                'status' => $status === 'inactive' ? 'inactive' : 'active',
                'id' => $newId,
            ];
            writeCategories($file, $categories);
            header('Location: /admin/categories?saved=1');
            exit;
        }
    }

    if ($action === 'update') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $status = (string) ($_POST['status'] ?? 'active');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($id <= 0 || $name === '') {
            $flash = 'Invalid category update.';
            $flashType = 'error';
        } else {
            foreach ($categories as &$category) {
                if ((int) ($category['id'] ?? 0) !== $id) {
                    continue;
                }
                $category['name'] = $name;
                $category['slug'] = $slug !== '' ? $slug : makeSlug($name);
                $category['description'] = $description;
                $category['sort_order'] = $sortOrder;
                $category['status'] = $status === 'inactive' ? 'inactive' : 'active';
            }
            unset($category);

            writeCategories($file, $categories);
            header('Location: /admin/categories?updated=1');
            exit;
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $categories = array_values(array_filter($categories, static fn($c) => (int) ($c['id'] ?? 0) !== $id));
            writeCategories($file, $categories);
            header('Location: /admin/categories?deleted=1');
            exit;
        }
    }
}

if (isset($_GET['saved'])) {
    $flash = 'Category created successfully.';
}
if (isset($_GET['updated'])) {
    $flash = 'Category updated successfully.';
}
if (isset($_GET['deleted'])) {
    $flash = 'Category deleted successfully.';
}
?>
<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }
</style>

<div class="bg-background text-on-background min-h-screen">
  <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
      <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
      <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1">
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/index"><span class="material-symbols-outlined">dashboard</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/inventory"><span class="material-symbols-outlined">inventory_2</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span></a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/categories"><span class="material-symbols-outlined">category</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Categories</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders"><span class="material-symbols-outlined">shopping_cart</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/customers"><span class="material-symbols-outlined">group</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/feedback"><span class="material-symbols-outlined">chat</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Feedback</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/messages"><span class="material-symbols-outlined">mail</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Messages</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/subscribers"><span class="material-symbols-outlined">mark_email_read</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Subscribers</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/reports"><span class="material-symbols-outlined">analytics</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/settings"><span class="material-symbols-outlined">settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/permissions"><span class="material-symbols-outlined">admin_panel_settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Permissions</span></a>
    </nav>
  </aside>

  <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <h2 class="font-black text-primary text-xl tracking-tight">Category Editor</h2>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span><?php endif; ?></a>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right"><p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p><p class="text-[10px] text-slate-400">Operations Lead</p></div>
      </div>
    </div>
  </header>

  <main class="ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-6">
      <?php if ($flash !== ''): ?>
      <div class="px-4 py-3 rounded-xl <?php echo $flashType === 'error' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700'; ?> text-sm font-semibold"><?php echo htmlspecialchars($flash); ?></div>
      <?php endif; ?>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <h3 class="font-black text-primary text-lg mb-4">Add Category</h3>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-3">
          <input type="hidden" name="action" value="add" />
          <input class="rounded-lg border-slate-200 text-sm" type="text" name="name" placeholder="Category name" required />
          <input class="rounded-lg border-slate-200 text-sm" type="text" name="slug" placeholder="Slug (optional)" />
          <input class="rounded-lg border-slate-200 text-sm" type="text" name="description" placeholder="Description" />
          <input class="rounded-lg border-slate-200 text-sm" type="number" name="sort_order" value="0" />
          <div class="md:col-span-5 flex items-center justify-between gap-3">
            <select name="status" class="rounded-lg border-slate-200 text-sm"><option value="active">Active</option><option value="inactive">Inactive</option></select>
            <button class="px-5 py-2.5 bg-primary text-white rounded-xl font-bold text-sm" type="submit">Create Category</button>
          </div>
        </form>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
          <h3 class="font-black text-on-surface text-lg">Existing Categories</h3>
          <span class="text-xs text-slate-500"><?php echo count($categories); ?> total</span>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
              <tr>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Slug</th>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-left">Sort</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php foreach ($categories as $category): ?>
              <tr>
                <td class="p-3">
                  <form method="POST" class="contents">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="id" value="<?php echo (int) $category['id']; ?>" />
                    <input class="w-full rounded-lg border-slate-200" type="text" name="name" value="<?php echo htmlspecialchars((string) ($category['name'] ?? '')); ?>" required />
                </td>
                <td class="p-3"><input class="w-full rounded-lg border-slate-200" type="text" name="slug" value="<?php echo htmlspecialchars((string) ($category['slug'] ?? '')); ?>" /></td>
                <td class="p-3"><input class="w-full rounded-lg border-slate-200" type="text" name="description" value="<?php echo htmlspecialchars((string) ($category['description'] ?? '')); ?>" /></td>
                <td class="p-3"><input class="w-20 rounded-lg border-slate-200" type="number" name="sort_order" value="<?php echo (int) ($category['sort_order'] ?? 0); ?>" /></td>
                <td class="p-3">
                  <select name="status" class="rounded-lg border-slate-200">
                    <option value="active" <?php echo (($category['status'] ?? 'active') === 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo (($category['status'] ?? 'active') === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </td>
                <td class="p-3 text-right space-x-2 whitespace-nowrap">
                  <button class="px-3 py-2 bg-primary text-white rounded-lg text-xs font-bold" type="submit">Save</button>
                  </form>
                  <form method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="id" value="<?php echo (int) $category['id']; ?>" />
                    <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>
</div>
