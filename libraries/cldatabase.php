<?php
class CLDatabase {	
	
        private $connection = null;
		
        public function insert( $statement = "" , $parameters = [] ){
            try{
				
                $this->executeStatement( $statement , $parameters );
                return $this->connection->lastInsertId();
				
            }catch(Exception $e){
                throw new Exception($e->getMessage());   
            }		
        }

        public function select( $statement = "" , $parameters = [] ){
            try{
				
                $stmt = $this->executeStatement( $statement , $parameters );
                return $stmt->fetchAll();
				
            }catch(Exception $e){
                throw new Exception($e->getMessage());   
            }		
        }
		
        public function update( $statement = "" , $parameters = [] ){
            try{
				
                $this->executeStatement( $statement , $parameters );
				
            }catch(Exception $e){
                throw new Exception($e->getMessage());   
            }		
        }		
		
       
        public function remove( $statement = "" , $parameters = [] ){
            try{
				
                $this->executeStatement( $statement , $parameters );
				
            }catch(Exception $e){
                throw new Exception($e->getMessage());   
            }		
        }		
        
        private function executeStatement( $statement = "" , $parameters = [] ){
            try{
			    $this->db_connect();
                $stmt = $this->connection->prepare($statement);
                $stmt->execute($parameters);
                return $stmt;
				
            }catch(Exception $e){
                throw new Exception($e->getMessage());   
            }		
        }
		
		
		 private function db_connect(){

            try{
				
                $this->connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";", DB_USER, DB_PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				
            } catch(Exception $e){
                throw new Exception($e->getMessage());   
            }			
        }
		
    }
	
?>