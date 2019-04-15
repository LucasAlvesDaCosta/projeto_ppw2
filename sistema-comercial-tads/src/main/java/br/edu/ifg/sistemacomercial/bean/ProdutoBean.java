/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.edu.ifg.sistemacomercial.bean;

import br.edu.ifg.sistemacomercial.dao.CategoriaDAO;
import br.edu.ifg.sistemacomercial.dao.ProdutoDAO;
import br.edu.ifg.sistemacomercial.entity.Categoria;
import br.edu.ifg.sistemacomercial.entity.Produto;
import br.edu.ifg.sistemacomercial.util.JsfUtil;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import javax.annotation.PostConstruct;
import javax.faces.bean.ManagedBean;
import javax.faces.bean.SessionScoped;

@ManagedBean
@SessionScoped
public class ProdutoBean extends JsfUtil{
    
    private Produto produto;
    private List<Produto> produtos;
    
    private ProdutoDAO produtoDAO;
    private CategoriaDAO categoriaDAO;
    
    public ProdutoBean() {
     
        produto = new Produto();
    }  
    
    
    @PostConstruct
    public void init(){
        produto = new Produto();
        produtos = new ArrayList<>();   
        produtoDAO = new ProdutoDAO();
        categoriaDAO = new CategoriaDAO();
    }
    
    public void novo(){
        produto = new Produto();
    }

    public void adicionarProduto(){
        try {
            produtoDAO.salvar(produto);
            produto = new Produto();
            addMensagem("Salvo com sucesso!");
            pesquisar();
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
        }
    }
    
    public void remover(Produto produto){
        try {
            produtoDAO.deletar(produto);
            produtos.remove(produto);
            addMensagem("Deletado com sucesso!");
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
        }
    }
    public void editar(Produto produto){
        //remover(produto);
        this.produto = produto;
    }
    
    public void pesquisar(){
        try {       
            produtos = produtoDAO.listar();
            if(produtos == null || produtos.isEmpty()){
                addMensagemAviso("Nenhum produto cadastrado.");
            }
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
        }
    }

    public Produto getProduto() {
        return produto;
    }

    public void setProduto(Produto produto) {
        this.produto = produto;
    }

    public List<Categoria> getCategorias() {
        try {
            return categoriaDAO.listar();
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
            return null;
        }
    }
    
    public List<Produto> getProdutos() {
        return produtos;
    }
    
    
}