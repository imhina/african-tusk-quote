<?php
/**
* Client Class
*/
class clients extends ATQ	{

    public function __construct() {
        parent::__construct();
    }
     // Iniating main method to display clients
    public function init() {
        ?>

        <h1><?php echo get_admin_page_title(); ?> <a href="<?php echo admin_url('admin.php?page=' . $this->page . '&action=form'); ?>" class="page-title-action">Add Clients</a></h1>

        <?php $this->notify('clients'); ?>

        <table class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                    <th width="15%"> First Name</th>
                    <th width="15%">Lat Name</th>
                    <th width="15%">Email</th>
                    <th width="15%">Contact No</th>
                    <th width="15%">Cell No</th>
                    <th width="15%">Company Name</th>
                    <th width="10%" class="actions">Actions</th>
                </tr>
            </thead>

            <tbody id="the-list">

                <?php
                // Getting clients
                $results = $this->wpdb->get_results("SELECT * FROM $this->clients_tbl");

                if ($results) {

                    foreach ($results as $row) {
                        ?>
                        <tr>
                            <td class="column-title">
                                <strong><a href="<?php echo admin_url('admin.php?page=' . $this->page . '&action=form&id=' . $row->client_id); ?>"><?php echo $row->client_fname; ?></a></strong>
                            </td>
                            <td><?php echo $row->client_lname; ?></td>
                            <td><?php echo $row->client_email; ?></td>
                            <td><?php echo $row->client_contactno; ?></td>
                            <td><?php echo $row->client_cellno; ?></td>
                            <td><?php echo $row->client_companyname; ?></td>
                            <td class="actions">
                                <a href="<?php echo admin_url('admin.php?page=' . $this->page . '&action=form&id=' . $row->client_id); ?>" class="dashicons-before dashicons-edit" title="Edit"></a> 
                                <a href="<?php echo admin_url('admin.php?page=' . $this->page . '&action=del&id=' . $row->client_id); ?>" class="dashicons-before dashicons-trash" title="Delete" onclick="return confirm('Are you sure you want to delete this?');"></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6" style="text-align: center;"><strong>No Records Found</strong></td>
                    </tr>
                    <?php
                }
                ?>

            </tbody>

        </table>
        <?php
    }
    // Add new or edit client
    public function form() {

        // Getting client data if user requests to edit
        $id = filter_input(INPUT_GET, 'id');
        $row = $this->wpdb->get_row("SELECT * FROM $this->clients_tbl WHERE client_id = $id");
        ?>

        <h1><?php echo isset($id) ? 'Edit Client' : 'Add New Client'; ?></h1>

        <div class="col-left">
            <form method="post" action="<?php echo admin_url('admin.php?page=' . $this->page . '&action=save'); ?>">
                <input type="hidden" name="client_id" value="<?php echo $id; ?>">
                <div class="form-field">
                    <label for="client_fname"> FirstName <span>*</span></label><br>
                    <input name="client_fname" id="client_fname" type="text" value="<?php echo $row->client_fname; ?>" required>
                </div>
                <div class="form-field">
                    <label for="client_lname">Last Name <span>*</span></label><br>
                    <input name="client_lname" id="client_lname" type="text" value="<?php echo $row->client_lname; ?>" required>
                </div>
                <div class="form-field">
                    <label for="client_email">Email <span>*</span></label><br>
                    <input type="text" name="client_email" id="client_email" value="<?php echo $row->client_email; ?>" required>
                    </div>
                    <div class="form-field">
                    <label for="client_contactno">Contact No<span>*</span></label><br>
                    <input type="text" name="client_contactno" id="client_contactno" value="<?php echo $row->client_contactno; ?>" required> 
                </div>
                <div class="form-field">
                    <label for="client_cellno">Cell No <span>*</span></label><br>
                    <input type="text" name="client_cellno" id="client_cellno" value="<?php echo $row->client_cellno; ?>" required> 
                </div>
                <div class="form-field">
                    <label for="client_companyname">Company Name<span>*</span></label><br>
                    <input type="text" name="client_companyname" id="client_companyname" value="<?php echo $row->client_companyname; ?>" required> 
                </div>




                
                
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo isset($id) ? 'Update Client' : 'Add New Client'; ?>"></p>
            </form>
        </div>

        <?php
    }

    // Save Client
    public function save() {

        // Getting submitted data
        $id = filter_input(INPUT_POST, 'client_id');
        $client_fname = filter_input(INPUT_POST, 'client_fname', FILTER_SANITIZE_STRING);
        $client_lname = filter_input(INPUT_POST, 'client_lname', FILTER_SANITIZE_STRING);
        $client_email = filter_input(INPUT_POST, 'client_email', FILTER_SANITIZE_STRING);
        $client_contactno = filter_input(INPUT_POST, 'client_contactno', FILTER_SANITIZE_STRING);
        $client_cellno = filter_input(INPUT_POST, 'client_cellno', FILTER_SANITIZE_STRING);
        $client_companyname = filter_input(INPUT_POST, 'client_companyname', FILTER_SANITIZE_STRING);

        if (!empty($id)) {

            $this->wpdb->update($this->clients_tbl, array('client_fname' => $client_fname, 'client_lname' => $client_lname, 'client_email' => $client_email, 'client_contactno' => $client_contactno, 'client_cellno' => $client_cellno, 'client_companyname' => $client_companyname), array('client_id' => $id));

            wp_redirect(admin_url('admin.php?page=' . $this->page . '&update=updated'));

            exit;
        } else {

            $this->wpdb->insert($this->clients_tbl, array('client_fname' => $client_fname, 'client_lname' => $client_lname, 'client_email' => $client_email, 'client_contactno' => $client_contactno, 'client_cellno' => $client_cellno, 'client_companyname' => $client_companyname));

            wp_redirect(admin_url('admin.php?page=' . $this->page . '&update=added'));

            exit;
        }
    }
     // Delete client
    public function del() {

        // Getting client id
        $id = filter_input(INPUT_GET, 'id');

        $this->wpdb->delete($this->clients_tbl, array('client_id' => $id));

        wp_redirect(admin_url('admin.php?page=' . $this->page . '&update=deleted'));

        exit;
    }

}