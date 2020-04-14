<?php

use GuzzleHttp\Client;

class News_m extends CI_model
{

	private $_client;

	public function __construct()
	{
		$this->_client 	= new Client([
			'base_uri' 	=> 'http://ispumaps.id/ispumapapi/'
		]);
	}

	public function get_aqmnews($keyword)
	{
		try
		{
			$response = $this->_client->request('GET', 'api/aqmnews', [
				'query' => [
					'trusur_api_key' => 'VHJ1c3VyVW5nZ3VsVGVrbnVzYV9wVA==',
					'k' => $keyword
				],
			]);

			$result = json_decode($response->getBody()->getContents(), true);

			return $result['data'];
		}
		catch (GuzzleHttp\Exception\ClientException $e)
		{
			$response = $e->getResponse();
			$responseBodyAsString = $response->getBody()->getContents();
		}
	}

	// public function add_aqmnews()
	// {
	// 	$data = array(
	// 		'title' 			=> $this->input->post('title'),
	// 		'slug' 				=> $this->input->post('slug'),
	// 		'content' 			=> $this->input->post('content'),
	// 		'created_at' 		=> $this->input->post('created_at'),
	// 		'created_by' 		=> $this->input->post('created_by')
	// 	);
	// 	return $this->db->insert('news', $data);
	// }

	// public function update_aqmnews($data, $id)
	// {
	// 	$this->db->update('news', $data, ['id' => $id]);
	// 	return $this->db->affected_rows();
	// }

	// public function delete_aqmnews($id)
	// {
	// 	$this->db->where('id', $id);
	// 	$this->db->delete('news');
	// 	return TRUE;
	// }
}
