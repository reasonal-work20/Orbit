<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

class Modal
{
    private string $id;
    private string $size;

    public function __construct(string $id = 'generic-modal', string $size = 'medium')
    {
        $this->id = $id;
        $this->size = $size;
    }

    /**
     * Modal Shell -> Generic wrapper for any content
     */

    public function render(string $title, string $content): string
    {
        ob_start(); ?>
        <div id="<?php echo $this->id; ?>" class="modal-overlay" style="display: none;">

            <div class="modal-container modal-size-<?php echo $this->size; ?>">
                <div class="modal-header">
                    <span class="modal-title"><?php echo htmlspecialchars($title); ?></span>
                    <button class="close-modal" onclick="closeModal('<?php echo $this->id; ?>')">
                        <?php
                        $xIcon = ROOT . ICONS . '/x-icon.svg';
                        if (file_exists($xIcon)) {
                            include $xIcon;
                        }
                        ?>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    <?php
        return ob_get_clean();
    }
}
?>